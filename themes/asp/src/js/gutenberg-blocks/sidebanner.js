const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
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

class SidebannerEdit extends Component {
  constructor(props) {
    super(props);

    this.state = {
      editMode: true,
    };
  }

  removeMedia = () => {
    const { attributes, setAttributes } = this.props;
    setAttributes({
      mediaId: 0,
      mediaUrl: "",
    });
  };

  onSelectMedia = (media) => {
    const { attributes, setAttributes } = this.props;
    setAttributes({
      mediaId: media.id,
      mediaUrl: media.url,
    });
  };

  getInspectorControls = () => {
    const { attributes, setAttributes } = this.props;

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
                onSelect={this.onSelectMedia}
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
                  onSelect={this.onSelectMedia}
                  allowedTypes={["image"]}
                  render={({ open }) => (
                    <Button onClick={open} isDefault isLarge>
                      {__("Replace image", "awp")}
                    </Button>
                  )}
                />
              </MediaUploadCheck>
            )}
            {attributes.mediaId != 0 && (
              <MediaUploadCheck>
                <Button onClick={this.removeMedia} isLink isDestructive>
                  {__("Remove image", "awp")}
                </Button>
              </MediaUploadCheck>
            )}
          </div>
        </PanelBody>
      </InspectorControls>
    );
  };

  getBlockControls = () => {
    const { attributes, setAttributes } = this.props;

    return (
      <BlockControls>
        <Toolbar>
          <Button
            label={this.state.editMode ? "Preview" : "Edit"}
            icon={this.state.editMode ? "format-image" : "edit"}
            onClick={() => this.setState({ editMode: !this.state.editMode })}
          />
        </Toolbar>
      </BlockControls>
    );
  };

  render() {
    const { attributes, setAttributes } = this.props;
    return [
      this.getInspectorControls(),
      this.getBlockControls(),
      <div>
        {this.state.editMode && (
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
        {!this.state.editMode && (
          <div className="section">
            <div
              className={attributes.bannerside + "side sidebanner"}
              style={
                "background:url(" +
                attributes.mediaUrl +
                ") no-repeat center center"
              }
            ></div>
            <div className="content">
              <RichText.Content tagName="h2" value={attributes.title} />
              <RichText.Content tagName="p" value={attributes.subtitle} />
            </div>
          </div>
        )}
      </div>,
    ];
  }
}

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
    mediaId: {
      type: "number",
      default: 0,
    },
    mediaUrl: {
      type: "string",
      default: "",
    },
  },
  edit: withSelect((select, props) => {
    return {
      media: props.attributes.mediaId
        ? select("core").getMedia(props.attributes.mediaId)
        : undefined,
    };
  })(SidebannerEdit),
  save: (props) => {
    const { attributes } = props;
    return (
      <div className="section">
        <div
          className={attributes.bannerside + "side sidebanner"}
          style={
            "background:url(" +
            attributes.mediaUrl +
            ") no-repeat center center"
          }
        ></div>
        <div className="content">
          <RichText.Content tagName="h2" value={attributes.title} />
          <RichText.Content tagName="p" value={attributes.subtitle} />
        </div>
      </div>
    );
  },
});
