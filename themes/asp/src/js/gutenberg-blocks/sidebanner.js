const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const el = wp.element.createElement;
 
registerBlockType('asp/sidebanner', {
	title: 'Side Banner',
	category: 'common',
	icon: 'smiley',
	description: 'Show a banner and text',
	keywords: ['example', 'test'],
	edit: () => {  
	//	return <div>:)</div> 
	return null;
	},
	save: () => { 
		return null;
	}
});