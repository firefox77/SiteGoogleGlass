import React, { Component } from 'react';
import {View, StyleSheet, Text, Button, TouchableOpacity, Image } from 'react-native';

class Botao extends Component {

  constructor(props){
    super(props);
    this.state = {};
    this.styles = StyleSheet.create({
      botao:{
        width:250,
        height:50,
        borderWidth:2,
        borderColor:props.color,
        backgroundColor:'transparent',
        borderRadius:25
      },
      botaoArea:{
        flex:1,
        flexDirection:'row',
        justifyContent:'center',
        alignItems:'center'
      },
      botaoText:{
        color:props.color,
        fontSize:14,
        fontWeight:'bold'      
      }
    });
  }

  render(){
    return(
      <TouchableOpacity style = {this.styles.botao} onPress={this.props.onPress}>
        <View style = {this.styles.botaoArea}>
          <Text style = {this.styles.botaoText}>{this.props.text}</Text>
        </View>
      </TouchableOpacity>
    );
  }
}

export default class BiscoitDaSorte extends Component {

  constructor(props){
    super(props);
    this.state = {texto:'Algum texto...'};

    this.frases = ['Ser solteiro não é tão ruim assim. Ruim é você ter alguém e ao mesmo tempo se sentir sozinho.', 'Sabe, ontem, eu estava pensando numa coisa quando adormeci; e, hoje, acordei pensando na mesma coisa, e concluí que eu não fui feita de costela alguma, nenhum homem teria uma costela tão poderosa pra fazer um ser tão especial assim.', 'O tempo anda passando tão rápido, mas tão rápido, que agora mesmo já passou.', 'O tempo conserta até o que ele mesmo estragou.'];

    this.quebrarBiscoito = this.quebrarBiscoito.bind(this);
  }

  quebrarBiscoito(){
    let s = this.state;
    
    let r = Math.floor(Math.random() * this.frases.length);

    s.texto = this.frases[r];
    this.setState(s);
  }

  render(){
    return (
      <View style= {styles.body}>
        <Image source = {require('./images/cookie.png')} />

        <Text style = {styles.texto}>"{this.state.texto}"</Text>

        <Botao color="#b59619" text="Quebrar Biscoito" onPress={this.quebrarBiscoito} />        
      </View>
    );
  }
}

const styles = StyleSheet.create({
  body:{
    paddingTop:20,
    flex:1,
    justifyContent:'center',
    alignItems:'center'
  },
  texto:{
    fontSize:17,
    color:'#b59619',
    margin:30,
    fontStyle:'italic'
  }  
});