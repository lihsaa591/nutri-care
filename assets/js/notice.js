( function () {
	var notice = document.querySelector( '.nutri-care-notice' );
	if ( ! notice ) {
		return;
	}

	var install = notice.querySelector( '[data-slug]' );
	if ( install && window.wp && window.wp.updates ) {
		install.addEventListener( 'click', function () {
			install.disabled = true;
			install.textContent = install.getAttribute( 'data-working' );
			window.wp.updates.installPlugin( {
				slug: install.getAttribute( 'data-slug' ),
				success: function () {
					window.location.href = install.getAttribute( 'data-activate-url' );
				},
				error: function ( response ) {
					var message = notice.querySelector( '.nutri-care-notice__error' );
					install.disabled = false;
					install.textContent = install.getAttribute( 'data-label' );
					if ( message ) {
						message.textContent = ( response && response.errorMessage ) || '';
						message.hidden = ! message.textContent;
					}
				},
			} );
		} );
	}

	notice.addEventListener( 'click', function ( event ) {
		if ( event.target.classList.contains( 'notice-dismiss' ) ) {
			window.fetch( notice.getAttribute( 'data-dismiss-url' ), {
				credentials: 'same-origin',
				redirect: 'manual',
			} );
		}
	} );
} )();
