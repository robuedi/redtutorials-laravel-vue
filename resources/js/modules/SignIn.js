export default class SignIn {

    constructor()
    {
        //get DOM
        this.formSectionBtns = document.querySelectorAll('[data-role="choose-action"] [data-action]');
        this.selfAddingClass = document.querySelectorAll('[data-self-add-class]');
        
        //bind events to DOM
        this.bindEvents();
    }

    bindEvents()
    {
        //on click activate section
        for(let formSectionBtn of this.formSectionBtns)
        {
            formSectionBtn.addEventListener('click', (e) => {
                this.activateSection(e.target);
            });   
        }
    
        for(let selfAddingClassElement of this.selfAddingClass)
        {
            selfAddingClassElement.addEventListener('click', (e) => {
                this.selfAddClass(e.target);
            });  
        };
               
        
    }

    activateSection(target)
    { 
        //diactivate all buttons
        const targetBtns = target.parentNode.querySelectorAll(':scope > [data-action]');
        for(let targetBtn of targetBtns)
        {
            targetBtn.classList.remove('active');
        }

        //activate only this button
        target.classList.add('active');

        //change active form
        //hide forms
        const forms = document.querySelectorAll('[data-role="choose-action-container"][data-type]');
        if(forms)
        {
            forms.forEach((form) => {
                form.classList.add('inactive');
            })   
        }

        //show button's form
        const currentActiveForm = target.getAttribute('data-action');
        document.querySelector('[data-role="choose-action-container"][data-type="'+currentActiveForm+'"]').classList.remove('inactive');
    }

    selfAddClass(target)
    {
        const className = target.getAttribute('data-self-add-class');

        //check if class already added
        //toggle class
        if(target.classList.contains(className))
        {
            target.classList.remove(className);
        }
        else
        {
            target.classList.add(className);
        }
    }
}