export default class MobileSidebarMenu {

    constructor()
    {
        //set DOM
        this.mainNavigation = document.querySelector('#main_navigation');
        this.triggerSidebar = document.querySelector('.trigger-sidebar');
        this.leftMenu = document.querySelector('#left_menu');
        this.body = document.querySelector('body');

        //set vars
        this.lastScrollTop  = 0;
        this.scrolledTop    = 0;

        //add elements events
        this.setEvents();
    }

    setEvents()
    {

        //on page load
        // Show/hide menu depending on scroll direction
        this.showHideMenu();
        
        window.onresize = () => {
            this.showHideMenu();
        }

        //on page scroll
        window.addEventListener('scroll', () => {
            this.showHideTopMenu();
        });

        //sidebar mobile
        if(this.triggerSidebar)
        {
            this.triggerSidebar.addEventListener('click', () => {
                this.toggleMobileSidebar();
            });    
        }
    }

    toggleMobileSidebar()
    {
        //toggle menu button
        if(this.triggerSidebar.classList.contains('trigger-open'))
        {
            this.triggerSidebar.classList.remove('trigger-open');
        }
        else
        {
            this.triggerSidebar.classList.add('trigger-open');
        }

        //toggle body display
        if(this.body.classList.contains('fixed-body'))
        {
            this.body.classList.remove('fixed-body');
        }
        else
        {
            this.body.classList.add('fixed-body');

        }
    }

    // Show/hide menu depending on scroll direction
    showHideMenu() {
        if(screen.width > 991)
        {
            this.mainNavigation.classList.remove('scroll-show-hide-enabled');
            return;
        }

        this.mainNavigation.classList.add('scroll-show-hide-enabled');
    }

    showHideTopMenu()
    {
        if(screen.width > 991)
        {
            return;
        }

        let st = window.pageYOffset;

        //if less then 100 scroll show menu
        if(st < 100)
        {
            this.mainNavigation.classList.remove('scroll-hide');
            return;
        }

        //check scroll direction
        if (st > this.lastScrollTop)
        {
            this.scrolledTop = 0;
            this.mainNavigation.classList.add('scroll-hide');
        }
        else
        {
            this.scrolledTop++;
            if(this.scrolledTop > 30)
            {
                this.mainNavigation.classList.remove('scroll-hide');
            }  
        }

        this.lastScrollTop = st;
    }
}

