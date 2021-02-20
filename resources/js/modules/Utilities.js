export default class Utilities {
	
	closest (childElement, parentSelector) {
		for ( ; childElement && childElement !== document; childElement = childElement.parentNode ) {
			if ( childElement.matches( parentSelector ) ) return childElement;
		}
		return null;
	};

	scrollTo(element, to, duration) {

    	if (duration <= 0) {
    		return;
    	}

		let difference = to - element.scrollTop;
		let perTick = difference / duration * 10;

    	setTimeout(() => {
        		element.scrollTop = element.scrollTop + perTick;
        		
        		if (element.scrollTop === to) {
        			return;
        		}
        		this.scrollTo(element, to, duration - 10);
    		}, 10);
		}

}