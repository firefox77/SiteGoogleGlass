import { StyleSheet } from 'react-native'
import uiTheme from '../../assets/uiTheme'
const styles = StyleSheet.create({
  cardContainer: {
    backgroundColor: '#FFF',
    borderWidth: 0,
    flex: 1,
    margin: 0,
    padding: 0,
  },
  container: {
    flex: 1,
  },
  emailContainer: {
    backgroundColor: '#FFF',
    flex: 1,
    paddingTop: 30,
  },
  headerBackgroundImage: {
    paddingBottom: 20,
    paddingTop: 35,
  },
  headerContainer: {
  	backgroundColor: uiTheme.palette.primaryTextColor,
  	paddingBottom: 20,
    paddingTop: 15,
  },
  headerColumn: {
    alignItems: 'center',
    backgroundColor: 'transparent',
    
  },
  placeIcon: {
    color: 'white',
    fontSize: 26,
  },
  scroll: {
    backgroundColor: '#FFF',
  },
  telContainer: {
    backgroundColor: '#FFF',
    flex: 1,
    paddingTop: 30,
  },
  userAddressRow: {
    alignItems: 'center',
    flexDirection: 'row',
  },
  userCityRow: {
    backgroundColor: 'transparent',
  },
  userCityText: {
    color: '#FFF',
    fontSize: 15,
    fontWeight: '600',
    textAlign: 'center',
  },
  userImage: {
    borderColor: "white",
    borderWidth: 3,
    height: 170,
    marginBottom: 15,
    width: 170,
  },
  userNameText: {
    color: '#FFF',
    fontSize: 18,
    fontWeight: 'bold',
    paddingBottom: 8,
    textAlign: 'center',
  },

  userInfo:{
  	flex:1,
  	height:70, 
  	flexDirection:'row'
  },

  userInfoMain:{
  	flex:3,
  	justifyContent: 'center'
  },

  smsIcon: {
    color: '#01C89E',
    fontSize: 30,
  },
  telIcon: {
    color: uiTheme.palette.primaryTextColor,
    fontSize: 30,
  },
  iconNumberColumn: {
  	flex:1,
  	justifyContent: 'center' 
  },
  backButton: {
    left: 20, 
    position: 'absolute',
  },
  slideIcon: { 
    padding: 5, 
  },
})
export default styles