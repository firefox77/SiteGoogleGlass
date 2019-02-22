import React, {Component} from 'react'
import { Text, View, ScrollView, TouchableOpacity } from 'react-native'
import styles from './styles'
import TabsSuite from './../../components/TabsSuite'
import IonIcons from 'react-native-vector-icons/Ionicons'
import Slider from '../../components/Slider'
import { BottomNavigation, ThemeContext, getTheme, COLOR, ActionButton } from 'react-native-material-ui'
import uiTheme from '../../assets/uiTheme'

class SuiteDetailsScreen extends Component {
     static navigationOptions = {
          header: null
     }
     constructor(props) {
          super(props);

          this.state = {
               active: 'Today',
               loading: false,
               suite: {},
          }
     }

     getSuite = () => {
          this.setState({ loading: true })    
     }
     componentWillMount() {
          uiTheme.palette.primaryTextColor= COLOR.purple500
     }
     render () {
          const episodes = [
               { id: 1, title: 'teste1' },
               { id: 2, title: 'teste3' },
          ]
          return (
               <ThemeContext.Provider value={getTheme(uiTheme)}>
                    <View style={{ flex: 1 }}>
                         <ScrollView style={ styles.wrapperContainer }>
                              { !this.state.loading ?
                                   <View>
                                        <Slider />
                                        <View style={ styles.titleContainer }>     
                                             <View style={ styles.titleWrapperContainer }>
                                                  <TouchableOpacity style={ styles.backButton } onPress={() => this.props.navigation.pop()}>
                                                       <IonIcons 
                                                            style={ styles.slideIcon }
                                                            name="md-arrow-back"
                                                            color="#fff"
                                                            size={ 25 }
                                                       />
                                                  </TouchableOpacity>
                                                  <Text style={ styles.title }>Nome da Suite</Text>
                                                  <TouchableOpacity style={ styles.favoriteButton } onPress={() => {}}>
                                                       <IonIcons 
                                                            style={ styles.slideIcon }
                                                            name="md-heart"
                                                            color="#fff"
                                                            size={ 25 }
                                                       />
                                                  </TouchableOpacity>
                                             </View>   
                                        </View>
                                        <TabsSuite episodes={episodes} />
                                   </View>
                              : null }
                         </ScrollView>
                         <ActionButton
                    //actions={['email', { icon: 'phone', label: 'Phone' }, 'sms', 'favorite']}
                    icon="check"
                    // transition="speedDial"
                />
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
                    </View>
               </ThemeContext.Provider>
                
          )
     }
}

export default SuiteDetailsScreen