const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const el = wp.element.createElement;

registerBlockType("asp/sidebanner", {
  title: "Side Banner",
  category: "common",
  icon: "smiley",
  description: "Show a banner and text",
  keywords: ["example", "test"],
  attributes: {
    title: {
      type: "string",
      selector: "h2",
    },
    subtitle: {
      type: "array",
      source: "children",
      selector: "p",
    },
    image: {
      type: "image",
      selector: "img",
    },
  },
  edit: function (props) {
    function onChangeSubtitle(content) {
      props.attributes({ subtitle: content });
    }
	function onChangeTitle(content) {
		props.attributes({ title: content });
	  }
	  function onChangeImage(content) {
		props.attributes({ image: content });
	  }
    return (
      <div className={props.className}>
        <div class="gray-bg">
		<RichText
            tagName="h2"
            role="textbox"
            aria-multiline="true"
            value={props.attributes.title}
            onChange={onChangeTitle}
          />
          <RichText
            tagName="p"
            role="textbox"
            aria-multiline="true"
            value={props.attributes.subtitle}
            onChange={onChangeSubtitle}
          />
        </div>
      </div>
    );
    //return null;
  },
  save: () => {
    return null;
  },
});
