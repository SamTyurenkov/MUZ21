const { registerBlockType } = wp.blocks;
 
registerBlockType('asp/sidebanner', {
	title: 'Side Banner',
	category: 'common',
	icon: 'smiley',
	description: 'Show a banner and text',
	keywords: ['example', 'test'],
	edit: () => {  
		return <div>:)</div> 
	},
	save: () => { 
		return <div>:)</div> 
	}
});