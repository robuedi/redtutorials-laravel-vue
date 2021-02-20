import Utilities from './Utilities';

export default class LessonContent {
    
    constructor(){
        
        this.container      = '';
        this.progressBar    = '';
        this.lessonProgress = '';
        this.sections       = '';
        this.prevBtn        = '';
        this.nextBtn        = '';
        this.nextLessonLink = '';
        this.currentActiveSection = '';
        this.sectionChangingLocked = false;
        this.utilities      = new Utilities();

    }

    load(){
        this.container = document.querySelector('[data-role="lessons-content"]');

        if(this.container !== null)
        {
            this.fetchDOM();
            this.events();
        }
    }

    fetchDOM()
    {
        this.lessonsList        = this.container.querySelector('[data-role="lessons-list"]');
        this.progressBar        = this.container.querySelector('[data-role="lesson-progress"]');
        this.lessonProgress     = this.progressBar.querySelectorAll(':scope > span');
        this.sections           = this.lessonsList.querySelectorAll('.lesson-container');
        this.prevBtn            = this.lessonsList.querySelector('.prev-load');
        this.nextBtn            = this.lessonsList.querySelector('.next-load');
        this.nextLessonLink     = site_url + this.nextBtn.getAttribute('data-next-lesson');
    }
    
    events(){
        let that = this;

        //next btn clicked
        this.nextBtn.addEventListener('click', () => {
            if(!this.sectionChangingLocked)
            {
                that.moveToSection('next');
            }
        });

        //next btn clicked
        this.prevBtn.addEventListener('click', () => {
            if(!this.sectionChangingLocked)
            {
                that.moveToSection('prev');
            }
        });

        //click on top nav
        this.lessonProgress.forEach((clickedBtn, index) => {
            clickedBtn.addEventListener('click', (e) => {
                if(!this.sectionChangingLocked)
                {
                    that.navigateByProgressBar(clickedBtn, index);
                }
            });

        })
    }

    moveToSection(direction)
    {
        //get current active
        this.setCurrentActiveSection();

        //nothing active, something's wrong
        if(!this.currentActiveSection)
        {
            return;
        }

        if(direction === 'next')
        {
            const sectionType = this.getSectionType();
            if(sectionType === 'quiz')
            {
                this.submitQuiz();
                return;
            }
        }

        //this applies also for prev and next
        this.moveToSectionByDirection(direction);
    }

    moveToSectionByDirection(direction)
    {
        //check any next or go to next lesson
        const nextSection = this.getNextSection(direction);

        if(nextSection)
        {
            this.navigateTo(this.currentActiveSection, nextSection, direction);
        }
        else
        {
            window.location.href = this.nextLessonLink;
        }
    }

    getCurrentSectionIndex()
    {
        return this.getSectionIndex(this.currentActiveSection);
    }

    getSectionIndex(section)
    {
        return Array.from(this.sections).indexOf(section);
    }

    getNextSection(direction)
    {
        const currentIndex = this.getCurrentSectionIndex();
        let nextIndex = currentIndex;
        if(direction === 'next')
        {
            nextIndex++;
        }
        else
        {
            nextIndex--;
        }

        return this.sections[nextIndex];
    }

    setCurrentActiveSection()
    {
        //get active section
        const currentActiveSectionArr = [...this.sections].filter(item => {
            if(item.classList.contains('active'))
            {
                return item;
            }
        });

        //check if the number of current section is only one
        // else something is not right
        if(currentActiveSectionArr.length <= 0)
        {
            return false;
        }

        this.currentActiveSection = currentActiveSectionArr[0];
    }

    submitQuiz()
    {
        const checkedOptions = this.getQuizResponses();
        const quizIdentification = this.getQuizIdentification();

        if(!quizIdentification)
        {
            this.showFeedback('warning', 'Something went wrong');

            return;
        };

        if(checkedOptions.length < 1)
        {
            this.showFeedback('warning', 'No option selected');

            return;
        };

        const that = this;

        //lock any other user action
        this.sectionChangingLocked = true;

        fetch('/ajax/v1'+window.location.pathname+window.location.search + '/' + quizIdentification, {
            method: "POST",
            credentials: "same-origin", // include, *same-origin, omit
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                response: checkedOptions,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            })
        })
        //validate response
        .then(response => {
           const validate = that.validateAjaxResponse(response);
           if(validate)
           {
               return validate;
           }
           else
           {
               this.sectionChangingLocked = false;
           }
        })
        .then(response => {
            that.processAjaxResponse(response);
        })
        .catch(error => {
            that.showFeedback('warning', 'Something went wrong');
            this.sectionChangingLocked = false;
        });
    }

    validateAjaxResponse(response)
    {
        const contentType = response.headers.get("content-type");
        if(contentType && contentType.includes("application/json"))
        {
            return response.json();
        }
        else
        {
            this.showFeedback('warning', 'Something went wrong');
            return '';
        }
    }

    processAjaxResponse(response)
    {
        if(response.status != 'success')
        {
            this.showFeedback('warning', 'Something went wrong')
            this.sectionChangingLocked = false;
            return;
        }

        //incorrect response
        if(response.response.action != 'pass')
        {
            this.showFeedback('warning', response.response.message)
            this.sectionChangingLocked = false;
            return;
        }

        //correct response
        //show feedback
        this.showFeedback('success', response.response.message);

        //move to next section
        const that = this;
        setTimeout(() =>  {
            //move next
            that.moveToSectionByDirection('next');
        }, 1500);
    }

    getQuizIdentification()
    {
        const quizForm = this.currentActiveSection.querySelector('.quiz-form');

        return quizForm.getAttribute('data-quiz');
    }

    getQuizResponses()
    {
        const quizForm = this.currentActiveSection.querySelector('.quiz-form');

        if(quizForm)
        {
            const checkedOptions = quizForm.querySelectorAll('input:checked');

            //get the values
            let arrValues = [];
            checkedOptions.forEach((element, index) =>  {
                arrValues.push(element.value);
            });

            return arrValues;
        }
        else
        {
            return [];
        }
    }

    navigateByProgressBar(clickedBtn, nextIndex)
    {
        if(clickedBtn.classList.contains('pre-active'))
        {
            //check direction
            let direction = this.getProgressDirection(clickedBtn);

            //get sections
            let currentContent  = this.lessonsList.querySelector('.lesson-container.active');
            let nextContent     = this.sections[nextIndex];

            //move to content
            this.navigateTo(currentContent, nextContent, direction);

            return;
        }

        //check if it's the next section
        this.setCurrentActiveSection();
        const followingIndex = this.getCurrentSectionIndex() + 1;
        if(followingIndex === nextIndex)
        {
            this.moveToSection('next');
        }
    }

    getProgressDirection(clickedBtn)
    {
        let activeBtn = this.progressBar.querySelector(':scope > span.active');
        let currentIndex = Array.from(this.progressBar.parentNode.children).indexOf(activeBtn);
        let nextIndex = Array.from(this.progressBar.parentNode.children).indexOf(clickedBtn);

        let direction = 'right';
        if(currentIndex > nextIndex)
        {
            direction = 'left';
        }

        return direction;
    }

    getSectionType()
    {
        let sectionType = this.currentActiveSection.getAttribute('data-type');
        if(sectionType === 'q')
        {
            return 'quiz';
        }
        else if (sectionType === 't')
        {
            return 'text';
        }
    }

    navigateTo(from, to, directionTo) {

        //check movement direction
        let fromClass = 'remove-to-left';
        let toClass = 'show-from-right';

        if(directionTo === 'prev')
        {
            fromClass = 'remove-to-right';
            toClass = 'show-from-left';
        }

        //hide the current one
        from.classList.add(fromClass);
        from.classList.remove('active');
        setTimeout(() =>  {
            from.classList.remove(fromClass);
        }, 500);

        //show the next one
        const classTransition = new Promise(resolve => {
            setTimeout(() =>  {
                to.classList.add(toClass);

                resolve();
            }, 490);
        });

        classTransition
        .then(()=>{
            to.classList.add('active');
        })
        .then(()=>{
            setTimeout(() =>  {
                to.classList.remove(toClass);
            }, 500);
        })
        .then(()=>{
            //scroll top
            //check if we should scroll
            let lessonsOffsetTop = document.getElementById("lessons_list").offsetTop;
            if(window.pageYOffset > (lessonsOffsetTop- 20))
            {
                this.utilities.scrollTo(document.documentElement, lessonsOffsetTop, 500)
            }
        });

        //set top progress
        this.preactivateCurrentProgress();
        const toSectionIndex = this.getSectionIndex(to);
        this.lessonProgress[toSectionIndex].classList.remove('pre-active');
        this.lessonProgress[toSectionIndex].classList.add('active');

        //unlock actions
        this.sectionChangingLocked = false;
    }

    preactivateCurrentProgress()
    {
        const currentProgress = this.getActiveLessonProgress();

        if(currentProgress)
        {
            currentProgress.classList.add('pre-active');
            currentProgress.classList.remove('active');
        }
    }

    getActiveLessonProgress()
    {
        //get active section
        const currentActiveProgressArr = [...this.lessonProgress].filter(item => {
            if(item.classList.contains('active'))
            {
                return item;
            }
        });

        //check if the number of current section is only one
        // else something is not right
        if(currentActiveProgressArr.length <= 0)
        {
            return false;
        }

        return  currentActiveProgressArr[0];
    }

    showFeedback(type, msg) {
        //set message
        let html = document.createElement("div");
        html.classList.add('ui-feedback');
        html.classList.add('hidden-temp');
        html.classList.add(type);

        html.innerHTML = `<span>${msg}</span>`;

        //append to active section
        this.clearFeedback();
        this.currentActiveSection.appendChild(html);

        //show message
        const feedbackMsg = new Promise((resolve => {
            setTimeout(() => {
                html.classList.remove('hidden-temp');
                resolve();
            }, 20);
        }));

        feedbackMsg.then(()=>{
            //hide message
            setTimeout(() =>  {
                html.classList.add('hidden-temp');
            }, 1500);
        })
        .then(()=>{
            //remove message
            setTimeout(() =>  {
                html.remove();
            }, 3000);
        })
    }

    clearFeedback() {
        const feedbackMsg = this.currentActiveSection.querySelector('.ui-feedback');
        if(feedbackMsg)
        {
            feedbackMsg.remove();
        }
    }
}