const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { RichText, InspectorControls, BlockControls, AlignmentToolbar } = wp.blockEditor;
const {
  ToggleControl,
  PanelBody,
  PanelRow,
  CheckboxControl,
  SelectControl,
  ColorPicker,
  TextControl,
  TextareaControl,
} = wp.components;

registerBlockType("asp/sidebanner", {
  title: "Side Banner",
  category: "common",
  icon: "smiley",
  description: "Show a banner and text",
  keywords: ["example", "test"],
  attributes: {
    title: {
      type: "string",
      default: "Заголовок",
    },
    subtitle: {
      type: "string",
      default: "Описание",
      source: "html",
      selector: "p",
    },
    bannerside: {
      type: "string",
      default: "left",
    },
    postIds: {
      type: "array",
      default: [],
    },
  },
  edit: (props) => {
    const { attributes, setAttributes } = props;
    console.log(props);
    return (
      <div>
        <InspectorControls>
          <PanelBody title="Настройки блока" initialOpen={true}>
            <PanelRow>
              <SelectControl
                label="С какой стороны баннер?"
                value={attributes.bannerside}
                options={[
                  { label: "Слева", value: "left" },
                  { label: "Справа", value: "right" },
                ]}
                onChange={(newval) => setAttributes({ bannerside: newval })}
              />
            </PanelRow>
          </PanelBody>
        </InspectorControls>
		<BlockControls>
	<Toolbar>
		<IconButton
			label="My very own custom button"
			icon="edit"
			className="my-custom-button"
			onClick={() => console.log('pressed button')}
		/>
	</Toolbar>
</BlockControls>

        <RichText
          value={attributes.title}
          tagName="h2"
          onChange={(newtext) => setAttributes({ title: newtext })}
        />
        <RichText
          value={attributes.subtitle}
          tagName="p"
          onChange={(newtext) => setAttributes({ subtitle: newtext })}
        />
      </div>
    );
  },
  save: (props) => {
    const { attributes } = props;
    return (
      <div class="section">
	  <div class="banner " className={attributes.bannerside}>

	  </div>
	  <div class="content">
        <RichText.Content tagName="h2" value={attributes.title} />
        <RichText.Content tagName="p" value={attributes.subtitle} />
	  </div>
      </div>
    );
  },
});
