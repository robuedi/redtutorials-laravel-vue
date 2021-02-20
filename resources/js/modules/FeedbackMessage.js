import Utilities from './Utilities';

export default class FeedbackMessage {

	constructor()
	{
		const utilities = new Utilities;

		//remove the feedback box on close button pressed
		const closeBtns = document.querySelectorAll('.alert .close'); 

		//add closing action
		for(let closeBtn of closeBtns)
		{
			closeBtn.addEventListener('click', (e) => {
				const parent = utilities.closest(e.target, '.alert');
				parent.remove();
			});	
		}
	}
}