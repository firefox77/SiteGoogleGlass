import { createStackNavigator, createAppContainer } from 'react-navigation'
import Home from './index'
import MotelDetailsScreen from './screens/MotelDetailsScreen'
import SuiteDetailsScreen from './screens/SuiteDetailsScreen'
import ProfileScreen from './screens/Profile'
import LoginScreen from './screens/Login'
import TimelineScreen from './screens/TimelineScreen'

const AppNavigator = createStackNavigator({
     Home,
     MotelDetailsScreen,
     SuiteDetailsScreen,
     ProfileScreen,
     LoginScreen,
     TimelineScreen
}, { headerMode: 'none', initialRouteName: 'Home' })


export default createAppContainer(AppNavigator)
