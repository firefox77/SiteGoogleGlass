( function( api ) {

	// Extends our custom "nataraj-dance-studio" section.
	api.sectionConstructor['nataraj-dance-studio'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );