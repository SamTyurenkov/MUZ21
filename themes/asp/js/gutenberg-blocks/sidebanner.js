const { registerBlockType } = wp.blocks;
 
registerBlockType('asp/sidebanner', {
	title: 'Side Banner',
	category: 'common',
	icon: 'smiley',
	description: 'Show a banner and text',
	keywords: ['example', 'test'],
	edit: () => {  
		return <div>edit</div> 
	},
	save: () => { 
		return <div>save</div> 
	}
});