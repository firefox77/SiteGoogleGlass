import { StyleSheet, Dimensions } from 'react-native'
import uiTheme from '../../../assets/uiTheme'

const { width } = Dimensions.get('window')
const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: '#fff',
    },
    priceBox: { 
        height: 105,
        backgroundColor: '#fff',
        padding: 15,
        width: width - 20,
        marginHorizontal: 10,
        marginTop: 0,
        borderBottomWidth: 1,
        borderBottomColor: '#ddd',
        flexDirection: 'row',
        marginBottom: 30,
    },
    priceContainer: { 
        marginTop: -30 
    },
    bodyBox: { 
        flex: 3, 
        height: 105 
    },
    text: { 
        fontWeight: 'bold', 
        color: uiTheme.palette.primaryTextColor 
    },
    additionalInfoContainer: { 
        flex: 1, 
        marginTop: 8 
    },
    additionalInfoText: { 
        lineHeight: 20, 
        color: '#8b8b8b' 
    },
    price: { 
        flex: 1, 
        borderLeftWidth: 1, 
        borderColor: '#ddd', 
        justifyContent: 'center', 
        alignItems: 'flex-end' 
    },



})
export default styles