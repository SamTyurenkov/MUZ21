const { registerBlockType } = wp.blocks;
const { InspectorControls, MediaUpload, MediaUploadCheck } = wp.blockEditor;
const { PanelBody, Button, ResponsiveWrapper } = wp.components;
const { Fragment } = wp.element;
const { withSelect } = wp.data;
const { __ } = wp.i18n;
 
const BlockEdit = (props) => {
	const { attributes, setAttributes } = props;
 
	const removeMedia = () => {
		props.setAttributes({
			mediaId: 0,
			mediaUrl: ''
		});
	}
 
 	const onSelectMedia = (media) => {
		props.setAttributes({
			mediaId: media.id,
			mediaUrl: media.url
		});
	}
 
	const blockStyle = {
		backgroundImage: attributes.mediaUrl != '' ? 'url("' + attributes.mediaUrl + '")' : 'none'
	};
	
	return (
		<Fragment>
			<InspectorControls>
				<PanelBody
					title={__('Select block background image', 'awp')}
					initialOpen={ true }
				>
					<div className="editor-post-featured-image">
						<MediaUploadCheck>
							<MediaUpload
								onSelect={onSelectMedia}
								value={attributes.mediaId}
								allowedTypes={ ['image'] }
								render={({open}) => (
									<Button 
										className={attributes.mediaId == 0 ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview'}
										onClick={open}
									>
										{attributes.mediaId == 0 && __('Choose an image', 'awp')}
										{props.media != undefined && 
						            			<ResponsiveWrapper
									    		naturalWidth={ props.media.media_details.width }
											naturalHeight={ props.media.media_details.height }
									    	>
									    		<img src={props.media.source_url} />
									    	</ResponsiveWrapper>
						            		}
									</Button>
								)}
							/>
						</MediaUploadCheck>
						{attributes.mediaId != 0 && 
							<MediaUploadCheck>
								<MediaUpload
									title={__('Replace image', 'awp')}
									value={attributes.mediaId}
									onSelect={onSelectMedia}
									allowedTypes={['image']}
									render={({open}) => (
										<Button onClick={open} isDefault isLarge>{__('Replace image', 'awp')}</Button>
									)}
								/>
							</MediaUploadCheck>
						}
						{attributes.mediaId != 0 && 
							<MediaUploadCheck>
								<Button onClick={removeMedia} isLink isDestructive>{__('Remove image', 'awp')}</Button>
							</MediaUploadCheck>
						}
					</div>
				</PanelBody>
			</InspectorControls>
			<div style={blockStyle}>
				... Your block content here...
			</div>
		</Fragment>
	);
};
 
 
registerBlockType('awp/imageselectinspector', {
	title: 'AWP Imageselect',
	icon: 'smiley',
	category: 'layout',
	supports: {
		align: true
	},
	attributes: {
		mediaId: {
			type: 'number',
			default: 0
		},
		mediaUrl: {
			type: 'string',
			default: ''
		}
	}, 
	edit: withSelect((select, props) => {
		return { media: props.attributes.mediaId ? select('core').getMedia(props.attributes.mediaId) : undefined };
	})(BlockEdit),
	save: (props) => {
		const { attributes } = props;
		const blockStyle = {
			backgroundImage: attributes.mediaUrl != '' ? 'url("' + attributes.mediaUrl + '")' : 'none'
		};
		return (
			<div style={blockStyle}>
				... Your block content here...
			</div>
		);
	}
});