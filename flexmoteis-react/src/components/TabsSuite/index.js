import React, {Component} from 'react'
import { Dimensions, Platform } from 'react-native';
import {SceneMap, TabView, TabBar, PagerPan, PagerScroll } from 'react-native-tab-view';
import Details from './Details'
import Prices from './Prices'
import Rating from './Rating'
import uiTheme from '../../assets/uiTheme';

const DetailsRoute = props => (  
    <Details { ...props } />
)
const PricesRoute = props => (
     <Prices { ...props } />
);
const RatingRoute = props => (
    <Rating { ...props } />
);

export default class TabsMotel extends Component {
     constructor(props){
          super(props);
          this.state = {
               index: 0,
               routes: [
                    {key: 'details', title: 'Detalhes', episodes: props.episodes},
                    {key: 'prices', title: 'Preços', episodes: props.episodes},
                    {key: 'rating', title: 'Avaliação', episodes: props.episodes}
               ]
          }
     }
     _handleIndexChange = index => this.setState({ index });

     _renderTabBar = props => <TabBar {...props} labelStyle={{ color: uiTheme.palette.primaryTextColor, fontWeight: 'bold' }} indicatorStyle={{ backgroundColor: uiTheme.palette.primaryTextColor }} style={{ backgroundColor: '#fff' }}/>;

     _renderScene = SceneMap({
          details: DetailsRoute.bind(this),
          prices: PricesRoute,
          rating: RatingRoute
     });

      _renderPager(props){
          return (Platform.OS === 'ios') ? <PagerScroll {...props} /> : <PagerPan {...props} />
     }

     render() {
          const {episodes} = this.props;
          return (
               <TabView
                    style={{ flex: 1, backgroundColor: '#fff' }}
                    navigationState={this.state}
                    renderScene={this._renderScene.bind(this)}
                    renderTabBar={this._renderTabBar}
                    onIndexChange={this._handleIndexChange}
                    initialLayout={{
                         width: Dimensions.get('window').width,
                         height: Dimensions.get('window').height,
                    }}
                    renderPager={this._renderPager}
               />
          )
     }
}