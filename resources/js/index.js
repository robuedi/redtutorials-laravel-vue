    import LessonContent from './modules/LessonContent';
    import CookieBar from './modules/CookieBar';
    import FeedbackMessage from './modules/FeedbackMessage';
    import MobileSidebarMenu from './modules/MobileSidebarMenu';
    import SignIn from './modules/SignIn';
    import hljs from './modules/libs/highlight.js/lib/highlight';
    import shell from './modules/libs/highlight.js/lib/languages/shell';
    import bash from './modules/libs/highlight.js/lib/languages/bash';
    import php from './modules/libs/highlight.js/lib/languages/php';
    import CourseContent from './modules/CourseContent';


document.addEventListener('DOMContentLoaded', () => {

    let cookieBar = new CookieBar();

    let feedbackMessage = new FeedbackMessage();

    let mobileSidebarMenu = new MobileSidebarMenu();

    let signIn = new SignIn();

    let courseCotent = new CourseContent();

    hljs.registerLanguage('php', php);
    hljs.registerLanguage('shell', shell);
    hljs.registerLanguage('bash', bash);
    hljs.initHighlightingOnLoad();

    let lessonContent = new LessonContent();
    lessonContent.load();
});
