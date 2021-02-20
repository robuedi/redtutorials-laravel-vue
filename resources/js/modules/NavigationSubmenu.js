
export default class CourseContent {

    constructor()
    {
        this.container      = document.querySelector('.chapters-list');

        //check if container exists in the page
        if(!this.container)
        {
            return;
        }

        this.chapterOption  = this.container.querySelectorAll('.chapter-option');

        this.load();
    }

    load()
    {
        //on chapter option click
        this.chapterOption.forEach((chapterOption) => {
            chapterOption.addEventListener('click', () => {
                this.chapterSelected(chapterOption);
            });
        })
    }

    chapterSelected(selectedChapterOption)
    {
        //hide all other options beside this one
        this.chapterOption.forEach((chapterOption) => {
            if(chapterOption === selectedChapterOption)
            {
                chapterOption.classList.add('active');
            }
            else
            {
                chapterOption.classList.remove('active');
            }
        })
    }


}