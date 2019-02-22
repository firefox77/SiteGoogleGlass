import React, {Component} from 'react'
import styles from './styles'
import { Card, Icon,Avatar } from 'react-native-elements'
import uiTheme from '../../assets/uiTheme'
import logo from '../../assets/img/logo-flex-branco.png'
import {
  Image,
  ImageBackground,
  ScrollView,
  Text,
  View
} from 'react-native';
import Container from '../../components/Container'


class ProfileScreen extends Component {

	constructor(props) {
		super(props);
}
  
    static navigationOptions = {
        header: null
		}
		
		// componentDidMount() {
		// 	.navigate('MotelDetailsScreen')
		// }



    renderHeader = () => {

      return (
        <View style={styles.headerContainer}>
					
          <ImageBackground
            style={uiTheme.palette.primaryTextColor}
            blurRadius={10}
            
          >
            <View style={styles.headerColumn}>
              <Avatar containerStyle={{borderColor:'white',borderWidth:3, marginBottom:15}} onPress={() => console.log("Works!")} size="xlarge" icon={{name: 'meetup', color: 'red', type: 'font-awesome'}} rounded source={{uri:"https://bootdey.com/img/Content/avatar/avatar6.png"}} showEditButton/>
              
              <Text style={styles.userNameText}>Nome do Cliente</Text>
              <View style={styles.userAddressRow}>
                <View>
                  <Icon
                    name="place"
                    underlayColor="transparent"
                    iconStyle={styles.placeIcon}
                  />
                </View>
                <View style={styles.userCityRow}>
                  <Text style={styles.userCityText}>
                    São Paulo, SP
                  </Text>
                </View>
              </View>
            </View>
          </ImageBackground>
        </View>
      )
    }

    
  	render() {
      return (
				<Container>        
					<ScrollView style={styles.scroll}>
          	<View style={styles.container}>
							<Card containerStyle={styles.cardContainer}>
								{this.renderHeader()}
							
							</Card>
            	<View style={styles.userInfo}>
								<View style={styles.iconNumberColumn}>
									<Icon
												name="call"
												underlayColor="transparent"
												iconStyle={styles.telIcon}
											/>
								</View>
								<View style={styles.userInfoMain}>
									<Text style={{fontWeight:'bold',fontSize:16, marginLeft:5 }}>
										+66 (089) 9234-0099
									</Text>
									<Text style={{color:'silver',marginLeft:5 }}>
										Mobile
									</Text>
								</View>
								<View style={styles.iconNumberColumn}>
									<Icon
													name="textsms"
													underlayColor="transparent"
													iconStyle={styles.smsIcon}
												/>
								</View>
          		</View>
            	<View style={styles.userInfo}>
								<View style={styles.iconNumberColumn}>
								
								</View>
								<View style={styles.userInfoMain}>
									<Text style={{fontWeight:'bold',fontSize:16, marginLeft:5 }}>
										+66 (089) 9234-0099
									</Text>
									<Text style={{color:'silver',marginLeft:5 }}>
										Trabalho
									</Text>
								</View>
								<View style={styles.iconNumberColumn}>
									
								</View>
            	</View>
							<View style={styles.userInfo}>
								<View style={styles.iconNumberColumn}>
									<Icon
													name="email"
													underlayColor="transparent"
													iconStyle={styles.telIcon}
												/>
								</View>
								<View style={styles.userInfoMain}>
									<Text style={{fontWeight:'bold',fontSize:16, marginLeft:5 }}>
										cliente@cliente.com.br
									</Text>
									<Text style={{color:'silver',marginLeft:5 }}>
										Trabalho
									</Text>
								</View>
								<View style={styles.iconNumberColumn}>
								</View>
							</View>
							<View style={styles.userInfo}>
								<View style={styles.iconNumberColumn}>
							</View>
							<View style={styles.userInfoMain}>
								<Text style={{fontWeight:'bold',fontSize:16, marginLeft:5 }}>
									321.456.789-01
								</Text>
								<Text style={{color:'silver',marginLeft:5 }}>
									CPF
								</Text>
							</View>
							<View style={styles.iconNumberColumn}>
							</View>
          	</View>
							<View style={styles.userInfo}>
								<View style={styles.iconNumberColumn}>
								</View>
								<View style={styles.userInfoMain}>
									<Text style={{fontWeight:'bold',fontSize:16, marginLeft:5 }}>
										12345-678
									</Text>
									<Text style={{color:'silver',marginLeft:5 }}>
										CEP
									</Text>
								</View>
								<View style={styles.iconNumberColumn}>
								</View>
								</View>
							</View>
        	</ScrollView>
				</Container>
				
      )
  	}

}

export default ProfileScreen