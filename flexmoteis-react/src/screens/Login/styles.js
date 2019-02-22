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

  headerBackgroundImage: {
    paddingBottom: 20,
    paddingTop: 35,
  },
  headerContainer: {
    backgroundColor: uiTheme.palette.primaryTextColor,
    paddingBottom: 20,
    paddingTop: 35,
  },
  headerColumn: {
    height: 130,
    alignItems: 'center',
    backgroundColor: 'transparent',
    
  },

  iconNumberColumn: {
    flex:1,
    justifyContent: 'center',
  },

  logo:{
    flex:1,
    width: '90%',
    height: 'auto'
  },

  buttonContainer: {
    height:45,
    flexDirection: 'row',
    justifyContent: 'center',
    alignItems: 'center',
    marginBottom:5,
    marginTop:5,
    width:'100%',
   
  },
  loginButton: {
    backgroundColor: '#43a047',
  },
  loginText: {
    color: 'white',
  },
  cadButton:{
    backgroundColor: '#673ab7',
  },

  rowSeparator:{
    flex:3,
    justifyContent: 'center'

  },

  input:{
    borderBottomWidth: 0.8,
    borderBottomColor: uiTheme.palette.primaryTextColor,
    paddingLeft: 10
    
  },

  separator: {
    flexDirection: 'row',
    borderColor: '#EDEDED',
    borderWidth: 0.8,
  },

  iconNumberColumn: {
    flex:1,
    justifyContent: 'center' 
  },

})
export default styles