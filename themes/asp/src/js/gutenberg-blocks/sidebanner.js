const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { ServerSideRender } = wp.editor;
const { registerBlockType } = wp.blocks;
const {
  RichText,
  InspectorControls,
  BlockControls,
  AlignmentToolbar,
  MediaUpload,
  MediaUploadCheck,
} = wp.blockEditor;
const { withSelect } = wp.data;
const {
  ToggleControl,
  PanelBody,
  PanelRow,
  CheckboxControl,
  SelectControl,
  ColorPicker,
  TextControl,
  TextareaControl,
  Toolbar,
  Button,
  Placeholder,
  Disabled,
  ResponsiveWrapper,
} = wp.components;

//class SidebannerEdit extends Component {
const SidebannerEdit = (props) => {
//   constructor(props) {
//     super(props);

    var state = {
      editMode: true,
    };
 // }
 const { attributes, setAttributes } = this.props;

  const { media } = useSelect( ( select, props ) => {		
	return {
		media: props.attributes.mediaId ? select( 'core' ).getMedia(props.attributes.mediaId) : undefined,
	};
} );

  const removeMedia = () => {
    setAttributes({
      mediaId: 0,
      mediaUrl: "",
    });
  };

  const onSelectMedia = (media) => {
    setAttributes({
      mediaId: media.id,
      mediaUrl: media.url,
    });
  };

  const getInspectorControls = () => {
    return (
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

        <PanelBody title="Выбор картинки" initialOpen={true}>
          <div className="editor-post-featured-image">
            <MediaUploadCheck>
              <MediaUpload
                onSelect={onSelectMedia}
                value={attributes.mediaId}
                allowedTypes={["image"]}
                render={({ open }) => (
                  <Button
                    className={
                      attributes.mediaId == 0
                        ? "editor-post-featured-image__toggle"
                        : "editor-post-featured-image__preview"
                    }
                    onClick={open}
                  >
                    {attributes.mediaId == 0 && __("Choose an image", "awp")}
                    {attributes.media != undefined && (
                      <ResponsiveWrapper
                        naturalWidth={attributes.media.media_details.width}
                        naturalHeight={attributes.media.media_details.height}
                      >
                        <img src={attributes.media.source_url} />
                      </ResponsiveWrapper>
                    )}
                  </Button>
                )}
              />
            </MediaUploadCheck>
            {attributes.mediaId != 0 && (
              <MediaUploadCheck>
                <MediaUpload
                  title={__("Replace image", "awp")}
                  value={attributes.mediaId}
                  onSelect={onSelectMedia}
                  allowedTypes={["image"]}
                  render={({ open }) => (
                    <Button onClick={open} isDefault>
                      {__("Replace image", "awp")}
                    </Button>
                  )}
                />
              </MediaUploadCheck>
            )}
            {attributes.mediaId != 0 && (
              <MediaUploadCheck>
                <Button onClick={removeMedia} isLink isDestructive>
                  {__("Remove image", "awp")}
                </Button>
              </MediaUploadCheck>
            )}
          </div>
        </PanelBody>
      </InspectorControls>
    );
  };

  const getBlockControls = () => {
    return (
      <BlockControls>
        <Toolbar>
          <Button
            label={state.editMode ? "Preview" : "Edit"}
            icon={state.editMode ? "format-image" : "edit"}
            onClick={() => state({ editMode: !state.editMode })}
          />
        </Toolbar>
      </BlockControls>
    );
  };

    return [
      getInspectorControls(),
      getBlockControls(),
      <div>
        {state.editMode && (
          <Fragment>
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
          </Fragment>
        )}
        {!state.editMode && (
          <ServerSideRender
		  block={props.name}
		  attributes={{
			blockname: "sidebanner",
			title: attributes.title,
			subtitle: attributes.subtitle,
			postlist: attributes.postlist,
			mediaUrl: attributes.mediaUrl
		  }}
		/>
        )}
      </div>,
    ];
  
}

registerBlockType("asp/sidebanner", {
  title: "Side Banner",
  category: "common",
  icon: "smiley",
  description: "Show a banner and text",
  keywords: ["example", "test"],
  attributes: {
	blockname: {
		type: "string",
		default: "sidebanner",
	},
    title: {
      type: "string",
      default: "Заголовок",
    },
    subtitle: {
      type: "string",
      default: "Описание",
    },
    bannerside: {
      type: "string",
      default: "left",
    },
    mediaId: {
      type: "number",
      default: 0,
    },
    mediaUrl: {
      type: "string",
      default: "",
    },
  },
  edit: SidebannerEdit, 
  save: () => { return null }
});
