jQuery( document ).ready( function() {
	jQuery( 'a.confirm').click( function() {
		if ( confirm( AJAN_Confirm.are_you_sure ) )
			return true; else return false;
	});
});

