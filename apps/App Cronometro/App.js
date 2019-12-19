import React, { Component } from 'react';
import { View, StyleSheet, Image, Text, TouchableOpacity } from 'react-native';

export default class AppCronometro extends Component {

  constructor(props){
    super(props);
    this.state = {n:0, botao:'VAI'};
    this.timer = null;



    this.vai = this.vai.bind(this);
    this.limpar = this.limpar.bind(this);
  }

  vai(){
    let s = this.state;


    if(this.timer != null){
      // PARAR O TIMER
      clearInterval(this.timer);
      this.timer = null;
      s.botao = "VAI";
    } else {
       // COMEÇAR O TIMER
      this.timer = setInterval(()=>{
        let s = this.state;
        s.n += 0.1;
        this.setState(s);
      }, 100);

      s.botao = "PARAR";
    }

    this.setState(s);
  }
  limpar(){
    if(this.timer != null){
      // PARAR O TIMER
      clearInterval(this.timer);
      this.timer = null;
    }

    let s = this.state;
    s.n = 0;
    s.botao = "VAI";
    this.setState(s);

  }

  render(){
    return (
      <View style = {styles.body}>
        <Image source = {require('./images/relogio.png')} />        
        <Text style = {styles.timer}>{this.state.n.toFixed(1)}</Text>
        <View style = {styles.botaoArea}>
          <TouchableOpacity style= {styles.botao} onPress = {this.vai}>
            <Text style = {styles.botaoText}>{this.state.botao}</Text>
          </TouchableOpacity>
          <TouchableOpacity style= {styles.botao} onPress = {this.limpar}>
            <Text style = {styles.botaoText}>Limpar</Text>
          </TouchableOpacity>
        </View>
      </View>      
    );
  }
}

const styles = StyleSheet.create({
  body:{
    paddingTop:20,
    flex:1,
    justifyContent:'center',
    alignItems:'center',
    backgroundColor: '#2c1f30'
  },
  timer:{
    color:'#baa07a',
    fontSize:80,
    fontWeight:'bold',
    backgroundColor: 'transparent',
    marginTop:-150
  },
  botaoArea:{
    flexDirection:'row',
    height:40,
    marginTop:80
  },
  botao:{
    flex:1,
    justifyContent:'center',
    alignItems:'center',
    backgroundColor: '#886532',
    height:40,
    borderRadius:5,
    margin:10  
  },
  botaoText:{
    fontSize:17,
    fontWeight:'bold',
    color:'#fff'
  }
});