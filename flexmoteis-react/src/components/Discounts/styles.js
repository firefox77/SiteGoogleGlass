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
    status: { 
        right: 10, 
        position: 'absolute' 
    },
    ticket: { 
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
    inactiveText: { 
        fontWeight: 'bold',
        paddingRight: 10, 
        fontSize: 12,
        textDecorationLine: 'line-through', 
        textDecorationStyle: 'solid'
    },
    activeText: {
        fontWeight: 'bold',
        paddingRight: 10, 
        fontSize: 12 
    },
    infoContainer: { 
        flex: 1, 
        justifyContent: 'flex-end', 
        flexDirection: 'row',
        top: 3
    },
    row: { 
        flexDirection: 'row' 
    },
    icon: { 
        paddingRight: 5, 
        top: 1 
    },
    code: { 
        flexDirection: 'row', 
        paddingHorizontal: 5 
    }
})
export default styles