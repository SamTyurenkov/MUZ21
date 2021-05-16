const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { RichText } = wp.blockEditor;
const { TextControl, TextareaControl } = wp.components;

registerBlockType("asp/sidebanner", {
  title: "Side Banner",
  category: "common",
  icon: "smiley",
  description: "Show a banner and text",
  keywords: ["example", "test"],
  attributes: {
	title: {
		type: 'string',
		default: 'Заголовок'
	},
	subtitle: {
		type: 'string',
		default: 'Описание'
	},
	postIds: {
		type: 'array',
		default: []
	}
},
  edit: (props) => { 
	const { attributes, setAttributes } = props;
	console.log(props);
	return (
		<div>
			<RichText 
			value={ attributes.title }
			onChange={(newtext) => setAttributes({ title: newtext })}
			/>
			<RichText 
			value={ attributes.subtitle }
			onChange={(newtext) => setAttributes({ subtitle: newtext })}
			/>
		</div>
	);
},
save: (props) => { 
	return <div>:)</div> 
}
});
