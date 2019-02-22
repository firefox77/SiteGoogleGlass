import React, {Component} from 'react'
import { Text, View, ScrollView, TouchableOpacity, TouchableWithoutFeedback, Image } from 'react-native'
import styles from './styles'
import IonIcons from 'react-native-vector-icons/Ionicons'
import Icon from 'react-native-vector-icons/FontAwesome'
import Slider from '../../components/Slider'
import { BottomNavigation, ThemeContext, getTheme } from 'react-native-material-ui'
import { Rating } from 'react-native-elements'
import uiTheme from '../../assets/uiTheme'

class MotelDetailsScreen extends Component {
     static navigationOptions = {
          header: null
     }
     constructor(props) {
          super(props);

          this.state = {
               active: 'Today',
               loading: false,
               motel: {},
          }
     }

     getMotel = () => {
          this.setState({ loading: true })    
     }
     render () {
          return (
               <ThemeContext.Provider value={getTheme(uiTheme)}>
                    <ScrollView style={ styles.wrapperContainer }>
                         { !this.state.loading ?
                              <View>
                                   <Slider />
                                   <TouchableOpacity style={ styles.backButton } onPress={() => this.props.navigation.pop()}>
                                        <IonIcons 
                                             style={ styles.slideIcon }
                                             name="md-arrow-back"
                                             color="#fff"
                                             size={ 25 }
                                        />
                                   </TouchableOpacity>
                                   <View style={ styles.containerMotelLogo }>
                                        
                                        <Image style={ styles.motelLogo } resizeMode="cover" source={{uri: 'https://motelbelle.com.br/wp-content/uploads/logo1.png'}} />
                                   </View>
                                   <View style={ styles.slideCaption }>     
                                        <TouchableOpacity onPress={() => this.props.navigation.goBack()}>
                                             <IonIcons 
                                                  style={ styles.slideIcon }
                                                  name="md-heart"
                                                  color="#fff"
                                                  size={ 25 }
                                             />
                                        </TouchableOpacity>                                                  
                                        <Text style={ [styles.slideText, styles.title] }>Motel Belle</Text>
                                        <Text style={ styles.slideText }>Rod. Raposo Tavares, KM 13</Text>
                                        <Text style={ styles.slideText }>São Paulo</Text>
                                   </View>
                                   <View style={ styles.suiteContainer }>
                                        <View style={ styles.rating }>
                                             <Text style={ [styles.subtitle, { marginBottom: 20 }] }>Suites</Text>
                                             <Rating
                                                  type="custom"
                                                  ratingColor={ uiTheme.palette.primaryTextColor }
                                                  ratingBackgroundColor="#fff"
                                                  imageSize={12}
                                                  readonly
                                                  startingValue={2}
                                                  style={ styles.starRating }
                                             />
                                        </View>
                                        <View style={ styles.suite }>
                                             <TouchableWithoutFeedback onPress={() => this.props.navigation.navigate('SuiteDetailsScreen')}>
                                                  <Image style={ styles.suiteImage } resizeMode="cover" source={{uri: 'https://www.flexmoteis.com.br/wp-content/uploads/2015/11/73b3f92f2f96a977f87b41d78caf5062.jpg'}} />
                                             </TouchableWithoutFeedback>
                                             <View style={ styles.wrapperSuiteContainer }>
                                                  <View style={ [styles.rating, styles.suiteRating] }>
                                                       <Text style={ [styles.subtitle, { marginBottom: 10 }] }>Luxo com Hidro</Text>
                                                       <Rating
                                                            type="custom"
                                                            ratingColor={ uiTheme.palette.primaryTextColor }
                                                            ratingBackgroundColor="#fff"
                                                            imageSize={12}
                                                            readonly
                                                            startingValue={2}
                                                            style={ styles.starRating }
                                                       />
                                                  </View>
                                                  <View style={ styles.iconsContainer }>
                                                       <View style={ styles.iconBox }>
                                                            <Icon name="wifi" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                                                       </View>
                                                       <View style={ styles.iconBox }>
                                                            <Icon name="tv" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                                                       </View>
                                                       <View style={ styles.iconBox }>
                                                            <Icon name="glass" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                                                       </View>
                                                       <View style={ styles.iconBox }>
                                                            <Icon name="car" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                                                       </View>
                                                       <TouchableOpacity onPress={() => {}}>
                                                            <View style={ styles.reserveButton }>
                                                                 <Text style={ styles.reserveButtonText }>Reservar</Text>
                                                            </View>
                                                       </TouchableOpacity>
                                                  </View>
                                             </View>
                                        </View>

                                        <View style={ styles.suite }>
                                             <TouchableWithoutFeedback onPress={() => this.props.navigation.navigate('SuiteDetailsScreen')}>
                                                  <Image style={ styles.suiteImage } resizeMode="cover" source={{uri: 'https://www.flexmoteis.com.br/wp-content/uploads/2015/11/73b3f92f2f96a977f87b41d78caf5062.jpg'}} />
                                             </TouchableWithoutFeedback>
                                             <View style={ styles.wrapperSuiteContainer }>
                                                  <View style={ [styles.rating, styles.suiteRating] }>
                                                       <Text style={ [styles.subtitle, { marginBottom: 10 }] }>Luxo com Hidro</Text>
                                                       <Rating
                                                            type="custom"
                                                            ratingColor={ uiTheme.palette.primaryTextColor }
                                                            ratingBackgroundColor="#fff"
                                                            imageSize={12}
                                                            readonly
                                                            startingValue={2}
                                                            style={ styles.starRating }
                                                       />
                                                  </View>
                                                  <View style={ styles.iconsContainer }>
                                                       <View style={ styles.iconBox }>
                                                            <Icon name="wifi" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                                                       </View>
                                                       <View style={ styles.iconBox }>
                                                            <Icon name="tv" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                                                       </View>
                                                       <View style={ styles.iconBox }>
                                                            <Icon name="glass" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                                                       </View>
                                                       <View style={ styles.iconBox }>
                                                            <Icon name="car" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                                                       </View>
                                                       <TouchableOpacity onPress={() => {}}>
                                                            <View style={ styles.reserveButton }>
                                                                 <Text style={ styles.reserveButtonText }>Reservar</Text>
                                                            </View>
                                                       </TouchableOpacity>
                                                  </View>
                                             </View>
                                        </View>

                                        <View style={ styles.suite }>
                                             <TouchableWithoutFeedback onPress={() => this.props.navigation.navigate('SuiteDetailsScreen')}>
                                                  <Image style={ styles.suiteImage } resizeMode="cover" source={{uri: 'https://www.flexmoteis.com.br/wp-content/uploads/2015/11/73b3f92f2f96a977f87b41d78caf5062.jpg'}} />
                                             </TouchableWithoutFeedback>
                                             <View style={ styles.wrapperSuiteContainer }>
                                                  <View style={ [styles.rating, styles.suiteRating] }>
                                                       <Text style={ [styles.subtitle, { marginBottom: 10 }] }>Luxo com Hidro</Text>
                                                       <Rating
                                                            type="custom"
                                                            ratingColor={ uiTheme.palette.primaryTextColor }
                                                            ratingBackgroundColor="#fff"
                                                            imageSize={12}
                                                            readonly
                                                            startingValue={2}
                                                            style={ styles.starRating }
                                                       />
                                                  </View>
                                                  <View style={ styles.iconsContainer }>
                                                       <View style={ styles.iconBox }>
                                                            <Icon name="wifi" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                                                       </View>
                                                       <View style={ styles.iconBox }>
                                                            <Icon name="tv" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                                                       </View>
                                                       <View style={ styles.iconBox }>
                                                            <Icon name="glass" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                                                       </View>
                                                       <View style={ styles.iconBox }>
                                                            <Icon name="car" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                                                       </View>
                                                       <TouchableOpacity onPress={() => {}}>
                                                            <View style={ styles.reserveButton }>
                                                                 <Text style={ styles.reserveButtonText }>Reservar</Text>
                                                            </View>
                                                       </TouchableOpacity>
                                                  </View>
                                             </View>
                                        </View>
                                   </View>
                              </View>
                         : null }
                    </ScrollView>
                    <BottomNavigation active={ this.state.active } >
                         <BottomNavigation.Action
                              key="today"
                              icon="today"
                              label="Moteis"
                              onPress={() => this.setState({ active: 'today' })}
                         />
                         <BottomNavigation.Action
                              key="people"
                              icon="map"
                              label="Favoritos"
                              onPress={() => this.setState({ active: 'people' })}
                         />
                         <BottomNavigation.Action
                              key="settings"
                              icon="settings"
                              label="Configurações"
                              onPress={() => this.setState({ active: 'settings' })}
                         />
                    </BottomNavigation>
               </ThemeContext.Provider>
                
          )
     }
}

export default MotelDetailsScreen