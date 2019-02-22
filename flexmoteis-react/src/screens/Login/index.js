import React, {Component} from 'react'
import styles from './styles'
import { Card, Icon } from 'react-native-elements'
import uiTheme from '../../assets/uiTheme'
import {
  Image,
  ImageBackground,
  ScrollView,
  Text,
  TextInput,
  View,
  Button,
  StyleSheet,
  TouchableHighlight
} from 'react-native';


class LoginScreen extends Component {


    static navigationOptions = {
        header: null
    }

    renderHeader = () => {

      return (
        <View style={styles.headerContainer}>
          <ImageBackground
            style={uiTheme.palette.primaryTextColor}
            blurRadius={10}
          >
            <View style={styles.headerColumn}>
              <Image
                style={styles.logo}
                source={require('../../assets/img/logo-flex-branco.png')}
              />
            </View>
          </ImageBackground>
        </View>
      )
    }



  	render() {
      return (
        <ScrollView>
          <View style={styles.container}>
            <Card containerStyle={styles.cardContainer}>
              {this.renderHeader()}
            </Card>
          </View>
          <View style={{marginTop:40}}>
            <View style={{alignItems: 'center'}}>
              <Text style={{color:uiTheme.palette.primaryTextColor,fontSize:16}}>Faça seu Login</Text>
            </View>
            <TextInput style={styles.input} placeholderTextColor='#9c27b0' placeholder='Email ou CPF' />
            <TextInput style={styles.input} placeholderTextColor='#9c27b0'  placeholder='Senha' />
            <View>
              <Text style={{textAlign:'right',color:uiTheme.palette.primaryTextColor,marginRight:10}}>Esqueci minha senha</Text>
            </View>
            <View style={{margin:7}} />
            <TouchableHighlight style={[styles.buttonContainer, styles.loginButton]} onPress={() => this.onClickListener('login')}>
              <Text style={styles.loginText}>Entrar</Text>
            </TouchableHighlight>

            <View style={{flex:1,height:20,flexDirection:'row'}} >
              <View style={{flex:1,justifyContent:'center'}}>
                 <View style={styles.separator} />
              </View>
              <View>
                <Text style={{flex:1,justifyContent:'center'}}>OU</Text>
              </View>
              <View style={{flex:1,justifyContent:'center'}}>
                <View style={styles.separator} />
              </View>
            </View>


            <TouchableHighlight style={[styles.buttonContainer, styles.cadButton]} onPress={() => this.onClickListener('login')}>
              <Text style={styles.loginText}>Cadastre-se</Text>
            </TouchableHighlight>
          </View>

        </ScrollView>
      )
  	}

}

export default LoginScreen