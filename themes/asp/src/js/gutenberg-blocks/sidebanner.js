const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { registerBlockType } = wp.blocks;
const { RichText, InspectorControls, BlockControls, AlignmentToolbar } =
  wp.blockEditor;
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
} = wp.components;

class SidebannerEdit extends Component {
  constructor(props) {
    super(props);

    this.state = {
      editMode: true,
    };
  }

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
        )}{" "}
        {!this.state.editMode && (
          <div className="section">
              <div className={attributes.bannerside + "side sidebanner"}></div>
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
    postIds: {
      type: "array",
      default: [],
    },
  },
  edit: SidebannerEdit,
  save: (props) => {
    const { attributes } = props;
    return (
      <div className="section">
        <div className={attributes.bannerside + "side sidebanner"}></div>
        <div className="content">
          <RichText.Content tagName="h2" value={attributes.title} />
          <RichText.Content tagName="p" value={attributes.subtitle} />
        </div>
      </div>
    );
  },
});
