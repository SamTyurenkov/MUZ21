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
  edit: (props) => { 
	console.log(props);
	return (
		<div>
			Text input:
			<TextControl /> 
			Textarea:
			<TextareaControl />
			Richtext:
			<RichText />
		</div>
	);
},
save: (props) => { 
	return <div>:)</div> 
}
});
