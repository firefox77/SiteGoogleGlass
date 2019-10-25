/**
* BLOCK: chatty-mango-guten-tag-tabs
*
*
* @package     Tag Groups
* @author      Christoph Amthor
* @copyright   2018 Christoph Amthor (@ Chatty Mango, chattymango.com)
* @license     GPL-3.0+
* @since       0.38
*/

//	Import CSS.
import './style.scss';
import './editor.scss';

import Select from 'react-select';
import apiFetch from '@wordpress/api-fetch';

const { __ } = wp.i18n;

const {
  createBlock,
  registerBlockType,
} = wp.blocks;

const {
  InspectorControls,
  PlainText,
} = wp.editor;

const {
  SelectControl,
  PanelBody,
  ToggleControl,
  RangeControl,
  ServerSideRender
} = wp.components;

const {
  Component,
} = wp.element;

const {
  siteUrl,
  siteLang,
  pluginUrl,
  hasPremium,
} = ChattyMangoTagGroupsGlobal;

const helpUrl = 'https://documentation.chattymango.com/documentation/';
const helpProduct = 'tag-groups-premium';
const helpComponent = 'tabbed-tag-cloud/tabbed-tag-cloud-parameters/';
const logoUrl = pluginUrl + '/assets/images/cm-tg-icon-64x64.png';


class TagGroupsHelp extends Component {
  render() {
    let href = helpUrl + helpProduct + "/" + helpComponent;

    if ( '' != siteLang ) {
      href += "?lang=" + siteLang;
    }

    href += "#" + this.props.topic;

    let tooltip = __( 'Click for help!' );

    return (
      <div>
      <a href={href} target="_blank" style={{textDecoration: 'none'}} title={tooltip}>
      <span className="dashicons dashicons-editor-help tg_right chatty-mango-help-icon"></span>
      </a>
      </div>
    );
  }
}


class tagGroupsTabbedCloudParameters extends Component {

  // Method for setting the initial state.
  static getInitialState( attributes ) {
    let selectedGroups = []; // empty means all
    let selectedTaxonomies = ['post_tag'];

    // We need arrays for the select elements.
    if ( attributes.include ) {
      selectedGroups = attributes.include.split(",")
    }

    if ( attributes.taxonomy ) {
      selectedTaxonomies = attributes.taxonomy.split(",")
    }

    return {
      groups: [],
      taxonomies: [],
      posts: [],
      selectedGroups: selectedGroups, // array representation
      selectedTaxonomies: selectedTaxonomies, // array representation
    };
  }


  // Constructing our component. With super() we are setting everything to 'this'.
  // Now we can access the attributes with this.props.attributes
  constructor() {
    super( ...arguments );

    this.groupsEndPoint = siteUrl + '/wp-json/tag-groups/v1/groups';
    this.termsEndPoint = siteUrl + '/wp-json/tag-groups/v1/terms';
    this.taxonomiesEndPoint = siteUrl + '/wp-json/tag-groups/v1/taxonomies';

    this.state = this.constructor.getInitialState( this.props.attributes );

    // Bind so we can use 'this' inside the method.
    this.getGroupsFromApi = this.getGroupsFromApi.bind( this );
    this.getTaxonomiesFromApi = this.getTaxonomiesFromApi.bind( this );
    this.getPostsFromApi = this.getPostsFromApi.bind( this );
    this.handleChangeInclude = this.handleChangeInclude.bind( this );
    this.handleChangeTaxonomy = this.handleChangeTaxonomy.bind( this );
    this.toggleOptionActive = this.toggleOptionActive.bind( this );
    this.toggleOptionCollapsible = this.toggleOptionCollapsible.bind( this );
    this.toggleOptionMouseover = this.toggleOptionMouseover.bind( this );
    this.toggleOptionHideEmpty = this.toggleOptionHideEmpty.bind( this );
    this.toggleOptionAdjustSeperatorSize = this.toggleOptionAdjustSeperatorSize.bind( this );
    this.toggleOptionAddPremiumFilter = this.toggleOptionAddPremiumFilter.bind( this );
    this.toggleOptionHideEmptyTabs = this.toggleOptionHideEmptyTabs.bind( this );
    this.toggleOptionShowTabs = this.toggleOptionShowTabs.bind( this );
    this.toggleOptionShowTagCount = this.toggleOptionShowTagCount.bind( this );

    // Load data from REST API.
    this.getGroupsFromApi();
    this.getTaxonomiesFromApi();
    this.getPostsFromApi();

  }


  handleChangeInclude( options ) {
    let selectedGroups = options.map( function( option ) {
      if ( ! isNaN( option.value ) ) {
        return option.value;
      }
    });

    // Set the state
    this.setState( { selectedGroups: selectedGroups } );

    // Set the attributes
    this.props.setAttributes( {
      include: selectedGroups.join(',')
    } );

    if ( selectedGroups.indexOf(0) > -1 ) {
      this.props.setAttributes( {
        show_not_assigned: 1
      } );
    } else {
      this.props.setAttributes( {
        show_not_assigned: 0
      } );
    }
  }


  handleChangeTaxonomy( options ) {
    let selectedTaxonomies = options.map( function( option ) {
      if ( typeof option.value === 'string' ) {
        return option.value;
      }
    });

    // Set the state
    this.setState( { selectedTaxonomies } );

    // Set the attributes
    this.props.setAttributes( {
      taxonomy: selectedTaxonomies.join(',')
    });
  }


  /**
  * Loading Groups
  */
  getGroupsFromApi() {
    // retrieve the groups
    apiFetch( { path: this.groupsEndPoint } ).then( groups => {
      if ( groups ) {
        this.setState({ groups });
      }
    });
  }


  /**
  * Loading Taxonomies (own REST API endpoint)
  */
  getTaxonomiesFromApi() {
    // retrieve the taxonomies
    apiFetch( { path: this.taxonomiesEndPoint } ).then( taxonomies => {
      if ( taxonomies ) {
        this.setState({ taxonomies });
      }
    });
  }


  /**
  * Loading Posts
  */
  getPostsFromApi() {
    apiFetch( { path: siteUrl + '/wp-json/wp/v2/posts?per_page=100' } ).then( fullPosts => {
      if ( fullPosts ) {
        let posts = [
          { value: -1, label: __('off') },
          { value: 0, label: __('use this post') }
        ];
        fullPosts.forEach( ( fullPost ) => {
          posts.push({
            value: fullPost.id,
            label: fullPost.title.rendered
          });
        } );
        this.setState({ posts });
      }
    });
  }


  toggleOptionActive() {
    let active = ( 1 === this.props.attributes.active ) ? 0 : 1;
    this.props.setAttributes( { active } );
  }

  toggleOptionCollapsible() {
    let collapsible = ( 1 === this.props.attributes.collapsible ) ? 0 : 1;
    this.props.setAttributes( { collapsible } );
  }

  toggleOptionMouseover() {
    let mouseover = ( 1 === this.props.attributes.mouseover ) ? 0 : 1;
    this.props.setAttributes( { mouseover } );
  }

  toggleOptionHideEmpty( ) {
    let hide_empty = ( 1 === this.props.attributes.hide_empty ) ? 0 : 1;
    this.props.setAttributes( { hide_empty } );
  }

  toggleOptionAdjustSeperatorSize() {
    let adjust_separator_size = ( 1 === this.props.attributes.adjust_separator_size ) ? 0 : 1;
    this.props.setAttributes( { adjust_separator_size } );
  }

  toggleOptionAddPremiumFilter( key ) {
    let add_premium_filter = ( 1 === this.props.attributes.add_premium_filter ) ? 0 : 1;
    this.props.setAttributes( { add_premium_filter } );
  }

  toggleOptionHideEmptyTabs( ) {
    let hide_empty_tabs = ( 1 === this.props.attributes.hide_empty_tabs ) ? 0 : 1;
    this.props.setAttributes( { hide_empty_tabs } );
  }

  toggleOptionShowTabs( ) {
    let show_tabs = ( 1 === this.props.attributes.show_tabs ) ? 0 : 1;
    this.props.setAttributes( { show_tabs } );
  }

  toggleOptionShowTagCount( ) {
    let show_tag_count = ( 1 === this.props.attributes.show_tag_count ) ? 0 : 1;
    this.props.setAttributes( { show_tag_count } );
  }

  render() {
    const {
      attributes,
      setAttributes
    } = this.props;

    const {
      active,
      add_premium_filter,
      adjust_separator_size,
      amount,
      append,
      assigned_class,
      collapsible,
      custom_title,
      div_class,
      div_id,
      groups_post_id,
      hide_empty,
      hide_empty_tabs,
      largest,
      link_append,
      link_target,
      mouseover,
      not_assigned_name,
      order,
      orderby,
      prepend,
      separator,
      separator_size,
      show_not_assigned,
      show_tag_count,
      show_tabs,
      smallest,
      tags_post_id,
      ul_class
    } = attributes;

    let optionsGroups = [], optionsTaxonomies = [];

    if( this.state.groups && this.state.groups.length > 0 ) {
      this.state.groups.forEach( ( group ) => {
        optionsGroups.push({ value:group.term_group, label:group.label });
      });
    }

    if( this.state.taxonomies && this.state.taxonomies.length > 0 ) {
      this.state.taxonomies.forEach( ( taxonomy ) => {
        optionsTaxonomies.push({ value:taxonomy.slug, label:taxonomy.name });
      });
    }

    if ( attributes.source !== 'gutenberg' ) {
      setAttributes({ source: 'gutenberg' });
    }

    return [
      (
        <InspectorControls key='inspector'>
          <div className='chatt-mango-inspector-control'>
            <PanelBody title={ __( 'Tags and Terms' ) } initialOpen={false}>
              <TagGroupsHelp topic="taxonomy"/>
              <label htmlFor="tg_input_taxonomy">
  						{ __( 'Include taxonomies' ) }
              </label>
              <Select
                id="tg_input_taxonomy"
                onChange={this.handleChangeTaxonomy}
                value={this.state.selectedTaxonomies}
                options={ optionsTaxonomies }
                multi={ true }
                closeOnSelect={ false}
                removeSelected={ true }
              />
              <TagGroupsHelp topic="smallest"/>
              <RangeControl
  							label={ __( 'Smallest font size' ) }
  							value={ smallest ? Number( smallest ) : 12 }
  							onChange={ ( value ) => { if ( value <= largest && value < 73 ) setAttributes( { smallest: value } ) } }
  							min={ 6 }
  							max={ 72 }
              />
              <TagGroupsHelp topic="largest"/>
              <RangeControl
  							label={ __( 'Largest font size' ) }
  							value={ largest ? Number( largest ) : 22 }
  							onChange={ ( value ) => { if ( smallest <= value && value > 5 ) setAttributes( { largest: value } ) } }
  							min={ 6 }
  							max={ 72 }
              />
              <TagGroupsHelp topic="amount"/>
              <RangeControl
  							label={ __( 'Tags per group' ) + ( amount == 0 ? ': ' + __( 'unlimited' ) : '' ) }
  							value={ amount ? Number( amount ) : 0 }
  							onChange={ ( amount ) => setAttributes( { amount } ) }
  							min={ 0 }
  							max={ 200 }
              />
              <TagGroupsHelp topic="orderby"/>
              <label htmlFor="tg_input_orderby">
  						{ __( 'Order tags by' ) }
              </label>
              <Select
                id="tg_input_orderby"
                onChange={ ( option ) => { if ( option ) setAttributes( { orderby: option.value } ) } }
                value={ orderby && typeof orderby === 'string' ? orderby : 'name' }
                options={ [
                  { value:'name', label:__('Name') },
                  { value:'natural', label:__('Natural sorting') },
                  { value:'count', label:__('Post count') },
                  { value:'slug', label:__('Slug') },
                  { value:'term_id', label:__('Term ID') },
                  { value:'description', label:__('Description') },
                ] }
              />
              <TagGroupsHelp topic="order"/>
              <label htmlFor="tg_input_order">
  						{ __( 'Sort order' ) }
              </label>
              <Select
                id="tg_input_order"
                onChange={ ( option ) => { if ( option ) setAttributes( { order: option.value } ) } }
                value={ order && typeof order === 'string' ? order.toUpperCase() : 'ASC' }
                options={ [
                  { value:'ASC', label:__('Ascending') },
                  { value:'DESC', label:__('Descending') }
                ] }
              />
              <TagGroupsHelp topic="hide_empty"/>
              <ToggleControl
                label={ __( 'Hide empty tags' ) }
                checked={ hide_empty }
                onChange={ this.toggleOptionHideEmpty }
              />
              <div>
              <TagGroupsHelp topic="separator"/>
              <label htmlFor="tg_input_separator">
  						{ __( 'Separator' ) }
              </label>
              </div>
              <PlainText
                id="tg_input_separator"
    						className="input-control"
    						value={ separator ? separator : '' }
    						placeholder={ __( 'Write here or leave empty.' ) }
    						onChange={ ( separator ) => setAttributes( { separator } ) }
              />
              { separator &&
                <div>
                  <TagGroupsHelp topic="adjust_separator_size"/>
                  <ToggleControl
                    label={ __( 'Adjust separator size to following tag' ) }
                    checked={ adjust_separator_size }
                    onChange={ this.toggleOptionAdjustSeperatorSize }
                  />
                  { ! adjust_separator_size &&
                    <div>
                    <TagGroupsHelp topic="separator_size"/>
                    <RangeControl
        							label={ __( 'Separator size' ) }
        							value={ separator_size ? Number( separator_size ) : 22 }
        							onChange={ ( separator_size ) => setAttributes( { separator_size } ) }
        							min={ 6 }
        							max={ 144 }
                    />
                  </div>
                  }
                </div>
              }
              <TagGroupsHelp topic="prepend"/>
              <div>
              <label htmlFor="tg_input_prepend">
  						{ __( 'Prepend' ) }
              </label>
              </div>
              <PlainText
                id="tg_input_prepend"
    						className="input-control"
    						value={ prepend ? prepend : '' }
    						placeholder={ __( 'Write here or leave empty.' ) }
    						onChange={ ( prepend ) => setAttributes( { prepend } ) }
              />
              <TagGroupsHelp topic="append"/>
              <div>
              <label htmlFor="tg_input_append">
  						{ __( 'Append' ) }
              </label>
              </div>
              <PlainText
                id="tg_input_append"
    						className="input-control"
    						value={ append ? append : '' }
    						placeholder={ __( 'Write here or leave empty.' ) }
    						onChange={ ( append ) => setAttributes( { append } ) }
              />
              { ! custom_title &&
                <div>
              <TagGroupsHelp topic="show_tag_count"/>
                <ToggleControl
                  label={ __( 'Show post count in the tooltip' ) }
                  checked={ show_tag_count }
                  onChange={ this.toggleOptionShowTagCount }
                />
                </div>
                }
                <div>
                <TagGroupsHelp topic="custom_title"/>
                <label htmlFor="tg_input_custom_title">
    						{ __( 'Custom title' ) }
                </label>
                </div>
                <PlainText
                  id="tg_input_custom_title"
      						className="input-control"
      						value={ custom_title ? custom_title : '' }
      						placeholder={ __( 'Write here or leave empty.' ) }
      						onChange={ ( custom_title ) => setAttributes( { custom_title } ) }
                />
              <TagGroupsHelp topic="link_target"/>
              <label htmlFor="tg_input_link_target">
  						{ __( 'Link target' ) }
              </label>
              <Select
                id="tg_input_link_target"
                onChange={ ( option ) => { if ( option ) setAttributes( { link_target:option.value } ) } }
                value={ ( link_target && ( typeof link_target === 'string' ) ) ? link_target : '_self' }
                options={ [
                  { value:'_self', label:'_self' },
                  { value:'_blank', label:'_blank' },
                  { value:'_parent', label:'_parent' },
                  { value:'_top', label:'_top' },
                ] }
              />
              <div>
              <label htmlFor="tg_input_link_append">
  						{ __( 'Append to link' ) }
              </label>
              </div>
              <PlainText
                id="tg_input_link_append"
    						className="input-control"
    						value={ link_append ? link_append : '' }
    						placeholder={ __( 'Write here or leave empty.' ) }
    						onChange={ ( link_append ) => setAttributes( { link_append } ) }
              />
              { hasPremium &&
                <div>
                <TagGroupsHelp topic="add_premium_filter"/>
                <ToggleControl
                  label={ __( 'Add filter to tags for multiple groups.' ) }
                  checked={ add_premium_filter }
                  onChange={ this.toggleOptionAddPremiumFilter }
                />
                </div>
              }
              <TagGroupsHelp topic="tags_post_id"/>
              <label htmlFor="tg_input_tags_post_id">
              { __( 'Use tags of the following post:' ) }
              </label>
              <Select
                id="tg_input_tags_post_id"
                onChange={ ( option ) => { if ( option ) setAttributes( { tags_post_id:option.value } ) } }
                value={ tags_post_id }
                options={ this.state.posts }
              />
            </PanelBody>

            <PanelBody title={ __( 'Groups and Tabs' ) } initialOpen={false}>
            <TagGroupsHelp topic="show_tabs"/>
              <ToggleControl
                label={ __( 'Show tabs' ) }
                checked={ show_tabs }
                onChange={ this.toggleOptionShowTabs }
              />
              <TagGroupsHelp topic="hide_empty_tabs"/>
              <ToggleControl
                label={ __( 'Hide empty tabs' ) }
                checked={ hide_empty_tabs }
                onChange={ this.toggleOptionHideEmptyTabs }
              />
              <TagGroupsHelp topic="mouseover"/>
              <ToggleControl
                label={ __( 'Open tabs on mouseover' ) }
                checked={ mouseover }
                onChange={ this.toggleOptionMouseover }
              />
              <TagGroupsHelp topic="collapsible"/>
              <ToggleControl
                label={ __( 'Make panels collapsible' ) }
                checked={ collapsible }
                onChange={ this.toggleOptionCollapsible }
              />
              <TagGroupsHelp topic="active"/>
              <ToggleControl
                label={ __( 'Start with expanded tabs' ) }
                checked={ active }
                onChange={ this.toggleOptionActive }
              />
              <TagGroupsHelp topic="include"/>
              <label htmlFor="tg_input_include">
  						{ __( 'Include groups' ) }
              </label>
              <Select
                id="tg_input_include"
                onChange={ this.handleChangeInclude }
                value={ this.state.selectedGroups }
                options={ optionsGroups }
                multi={ true }
                closeOnSelect={ false}
                removeSelected={ true }
              />
              { show_not_assigned === 1 &&
                <div>
                <div>
                <label htmlFor="tg_input_not_assigned_name">
                { __( 'Label on tab for not-assigned tags' ) }
                </label>
                </div>
                <PlainText
                id="tg_input_not_assigned_name"
                className="input-control"
                value={ not_assigned_name ? not_assigned_name : 'not assigned' }
                placeholder={ __( 'Write here or leave empty.' ) }
                onChange={ ( not_assigned_name ) => setAttributes( { not_assigned_name } ) }
                />
                </div>
              }
              <TagGroupsHelp topic="groups_post_id"/>
              <label htmlFor="tg_input_group_post_id">
  						{ __( 'Use groups of the following post:' ) }
              </label>
              <Select
                id="tg_input_group_post_id"
                onChange={ ( option ) => { if ( option ) setAttributes( { groups_post_id:option.value } ) } }
                value={ groups_post_id }
                options={ this.state.posts }
              />
            </PanelBody>

            <PanelBody title={ __( 'Advanced Styling' ) } initialOpen={false}>
            <div>
            <TagGroupsHelp topic="div_id"/>
            <label htmlFor="tg_input_div_id">
            { '<div id="...">' }
            </label>
            </div>
            <PlainText
              id="tg_input_div_id"
              className="input-control"
              value={ div_id ? div_id : '' }
              placeholder={ __( 'Write here or leave empty.' ) }
              onChange={ ( div_id ) => setAttributes( { div_id } ) }
            />
            <div>
            <TagGroupsHelp topic="div_class"/>
            <label htmlFor="tg_input_div_class">
            { '<div class="...">' }
            </label>
            </div>
            <PlainText
              id="tg_input_div_class"
              className="input-control"
              value={ div_class ? div_class : '' }
              placeholder={ __( 'Write here or leave empty.' ) }
              onChange={ ( div_class ) => setAttributes( { div_class } ) }
            />
            <div>
            <TagGroupsHelp topic="ul_class"/>
            <label htmlFor="tg_input_ul_class">
            { '<ul class="...">' }
            </label>
            </div>
            <PlainText
              id="tg_input_ul_class"
              className="input-control"
              value={ ul_class ? ul_class : '' }
              placeholder={ __( 'Write here or leave empty.' ) }
              onChange={ ( ul_class ) => setAttributes( { ul_class } ) }
            />
            { tags_post_id !== -1 &&
            <div>
            <div>
            <TagGroupsHelp topic="assigned_class"/>
            <label htmlFor="tg_input_assigned_class">
            { '<a class="..._0"> or <a class="..._1">' }
            </label>
            </div>
            <PlainText
              id="tg_input_assigned_class"
              className="input-control"
              value={ assigned_class ? assigned_class : '' }
              placeholder={ __( 'Write here or leave empty.' ) }
              onChange={ ( assigned_class ) => setAttributes( { assigned_class } ) }
            />
            </div>
            }
            </PanelBody>
            <div className="chatty-mango-help-transform">
              <TagGroupsHelp topic="transform-your-block-for-more-options"/>
              <div dangerouslySetInnerHTML={{ __html: __( 'If you want to customize further options, you need to transform the block into a <b>shortcode block</b>.' ) }}>
              </div>
            </div>
          </div>
        </InspectorControls>
      ),
      <div className="chatty-mango-editor">
        <table style={{border:'none'}}>
        <tr>
        <td>
        <img src={logoUrl} alt='logo' style={{float:'left', margin:15}}/>
        </td>
        <td>
          <h3>{ __( 'Tabbed Tag Cloud' ) }</h3>
          <div className="cm-gutenberg dashicons-before dashicons-admin-generic">
            { __( 'Select this block and customize the tag cloud in the Inspector.' ) }
            </div>
            <div className="cm-gutenberg dashicons-before dashicons-welcome-view-site">
            { __( 'See the output with Preview.' ) }
            </div>
        </td>
        </tr>
        </table>
      </div>
    ]
  }

}


/**
* Register: a Gutenberg Block.
*
* @param  {string}	  name	   Block name.
* @param  {Object}	  settings Block settings.
* @return {?WPBlock}		   The block, if it has been successfully
*							   registered; otherwise `undefined`.
*/
var cmTagGroupsTabsBlock = registerBlockType( 'chatty-mango/tag-groups-cloud-tabs', {
  title: __( 'Tabbed Tag Cloud' ),
  icon: 'tagcloud', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
  category: 'widgets',
  description: __( 'Show your tags in groups under tabs.' ),
  keywords: [
    __( 'tabs' ),
    __( 'tag cloud' ),
    'Chatty Mango',
  ],
  html: false,
  transforms: {
    to: [
      {
        type: 'block',
        blocks: [ 'core/shortcode' ],
        transform: function( attributes ) {
          let parameters = [];
          for ( var attribute in attributes ) {
            if (attributes.hasOwnProperty( attribute )) {
              if ( null !== attributes[attribute] && '' !== attributes[ attribute ] && 'source' !== attribute && cmTagGroupsTabsBlock.attributes[ attribute ] && attributes[ attribute ] !== cmTagGroupsTabsBlock.attributes[ attribute ].default ) {
                if ( typeof attributes[attribute] === 'number' ) {
                  parameters.push( attribute + '=' + attributes[ attribute ] );
                } else {
                  parameters.push( attribute + '="' + attributes[ attribute ] + '"');
                }
              }
            }
          }

          let text = '[tag_groups_cloud ' + parameters.join(' ') + ']';
          return createBlock( 'core/shortcode', {
            text
          } );
        },
      },
    ],
  },
  supports: {
    html: false,
  },

  /**
  * Attributes are the same as shortcode parameters
  **/
  attributes: {
    source: { // internal indicator to identify Gutebergb blocks
      type: 'string',
      default: ''
    },
    active: { // configurable in block
      type: 'integer',
      default: 1
    },
    adjust_separator_size: {// configurable in block
      type: 'integer',
      default: 1
    },
    add_premium_filter: {// configurable in block
      type: 'integer',
      default: 0
    },
    amount: {// configurable in block
      type: 'integer',
      default: 0
    },
    append: {// configurable in block
      type: 'string',
      default: ''
    },
    assigned_class: {// configurable in block
      type: 'string',
      default: ''
    },
    collapsible: {// configurable in block
      type: 'integer',
      default: 0
    },
    custom_title: {// configurable in block
      type: 'string',
      default: ''
    },
    div_class: {// configurable in block
      type: 'string',
      default: 'tag-groups-cloud'
    },
    div_id: {// configurable in block
      type: 'string',
      default: ''
    },
    exclude_terms: {// only in shortcode
      type: 'string',
      default: ''
    },
    groups_post_id: {// configurable in block
      type: 'integer',
      default: -1
    },
    hide_empty: {// configurable in block
      type: 'integer',
      default: 1
    },
    hide_empty_tabs: {// configurable in block
      type: 'integer',
      default: 0
    },
    include: {// configurable in block
      type: 'string',
      default: ''
    },
    include_terms: {// only in shortcode
      type: 'string',
      default: ''
    },
    largest: {// configurable in block
      type: 'integer',
      default: 22
    },
    link_append: {// configurable in block
      type: 'string',
      default: ''
    },
    link_target: {// configurable in block
      type: 'string',
      default: '_self'
    },
    mouseover: {// configurable in block
      type: 'integer',
      default: 0
    },
    not_assigned_name: {// configurable in block
      type: 'string',
      default: ''
    },
    order: {// configurable in block
      type: 'string',
      default: 'ASC'
    },
    orderby: {// configurable in block
      type: 'string',
      default: 'name'
    },
    prepend: {// configurable in block
      type: 'string',
      default: ''
    },
    separator_size: {// configurable in block
      type: 'integer',
      default: 22
    },
    separator: {// configurable in block
      tpye: 'string',
      default: ''
    },
    show_not_assigned: {// indirectly configurable in block
      type: 'integer',
      default: 0
    },
    show_all_groups: {// only in shortcode
      type: 'integer',
      default: 0
    },
    show_tabs: { // configurable in block
      type: 'integer',
      default: 1
    },
    show_tag_count: { // configurable in block
      type: 'integer',
      default: 1
    },
    smallest: {// configurable in block
      type: 'integer',
      default: 12
    },
    tags_post_id: {// configurable in block
      type: 'integer',
      default: -1
    },
    taxonomy: {// configurable in block
      type: 'string',
      default: ''
    },
    ul_class: {// configurable in block
      type: 'string',
      default: ''
    },
  },

  /**
  * Composing and rendering the editor content and control elements
  */
  edit: tagGroupsTabbedCloudParameters,


  /**
  * We don't render any HTML when saving
  */
  save: function( props ) {
    return null;
  },
} );
