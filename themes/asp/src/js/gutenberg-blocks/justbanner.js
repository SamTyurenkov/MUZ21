const { registerBlockType } = wp.blocks;
const { serverSideRender: ServerSideRender } = wp;
const { InspectorControls, MediaUpload, MediaUploadCheck } = wp.blockEditor;
const { PanelBody, Button, ResponsiveWrapper } = wp.components;
const { Fragment } = wp.element;
const { withSelect } = wp.data;
const { __ } = wp.i18n;

const BlockEdit = (props) => {
  const { attributes, setAttributes } = props;
  console.log(props);
  const removeMedia = () => {
    props.setAttributes({
      mediaId: 0,
      mediaUrl: "",
    });
  };

  const onSelectMedia = (media) => {
    props.setAttributes({
      mediaId: media.id,
      mediaUrl: media.url,
    });
  };

  return (
    <Fragment>
      <InspectorControls>
        <PanelBody
          title={__("Select block background image", "awp")}
          initialOpen={true}
        >
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
                    {props.media != undefined && (
                      <ResponsiveWrapper
                        naturalWidth={props.media.media_details.width}
                        naturalHeight={props.media.media_details.height}
                      >
                        <img src={props.media.source_url} />
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
      <ServerSideRender
        block={props.name}
        attributes={{
          blockname: "justbanner",
          mediaUrl: attributes.mediaUrl,
        }}
      />
    </Fragment>
  );
};

registerBlockType("asp/justbanner", {
  title: "Just Banner",
  icon: "smiley",
  category: "layout",
  supports: {
    align: true,
  },
  attributes: {
    blockname: {
      type: "string",
      default: "",
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
  })(BlockEdit),
  save: () => {
    return null;
  },
});
