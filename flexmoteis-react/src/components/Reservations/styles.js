import { StyleSheet, Dimensions } from 'react-native'
import uiTheme from '../../assets/uiTheme'

const { width } = Dimensions.get('window')
const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: '#fff',
        marginHorizontal: 20, 
        marginTop: 10
    },
    motelWrapperContainer: { 
        width: 80 
    },
    motelImage: {
        borderRadius: 60,
        height: 60,
        width: 60
    },
 
    suiteName: { 
        fontWeight: 'bold', 
        color: '#000', 
        marginBottom: 5 
    },
    hours: { 
        color: uiTheme.palette.primaryTextColor, 
        right: 10, 
        position: 'absolute' 
    },
    reservation: { 
        height: 'auto',
        backgroundColor: '#fff',
        paddingVertical: 15,
        width: width - 40,
        borderBottomWidth: 1,
        borderBottomColor: '#ddd',
        flexDirection: 'row'
    },
    content: {
        width: width - 110,
        justifyContent: 'center'
    },
    text: { 
        paddingRight: 10, 
        fontSize: 12 
    },
    infoContainer: { 
        flex: 1, 
        justifyContent: 'flex-end', 
        flexDirection: 'row' 
    },
    row: { 
        flexDirection: 'row' 
    }
})
export default styles