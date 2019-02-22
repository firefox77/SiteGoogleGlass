import { StyleSheet } from 'react-native'
import uiTheme from '../../assets/uiTheme'
const styles = StyleSheet.create({
    wrapperContainer: {
        flex: 1,
        backgroundColor: '#fff',
    },
    wrapperSuiteContainer: {
        marginHorizontal: 10
    },
    suiteContainer: {
        flex: 1,
        backgroundColor: '#fff',
        marginHorizontal: 20,
    },
    iconsContainer: { 
        flexDirection: 'row', 
        justifyContent: 'space-between', 
        marginBottom: 10 
    },
    titleWrapperContainer: { 
        flexDirection: 'row', 
        justifyContent: 'center', 
        alignItems: 'center', 
        flex: 1, 
        backgroundColor: 'transparent' 
    },
    reserveButton: { 
        width: 50, 
        height: 50, 
        justifyContent: 'center', 
        alignItems: 'center', 
        backgroundColor: uiTheme.palette.primaryTextColor 
    },
    reserveButtonText: { 
        color: '#fff', 
        fontSize: 11 
    },
    backButton: {
        top: 20,
        left: 20, 
        position: 'absolute',
    }, 
    slideIcon: { 
        padding: 5, 
    },
    subtitle: { 
        color: uiTheme.palette.primaryTextColor, 
        fontWeight: 'bold',
        marginBottom: 10,
    },
    title: { 
        fontWeight: 'bold', 
        fontSize: 18,
    },
    slideText: {
        color: '#fff',
        marginBottom: 3
    },
    rating: { 
        marginTop: 10, 
        justifyContent: 'space-between',
        flexDirection: 'row'
    },
    starRating: {
        top: 3
    },
    suiteRating: {
        marginTop: 10,
        height: 30
    },  
    suiteImage: {
        borderRadius: 15,
        height: 150,
        width: '100%'
    },
    iconBox: {
        backgroundColor: uiTheme.palette.grayBackground,
        width: 50, 
        height: 50, 
        justifyContent: 'center', 
        alignItems: 'center' 
    },
    slideCaption: { 
        width: '50%',
        height: 180, 
        top: 20, 
        right: 20, 
        position: 'absolute', 
        flexDirection: 'column', 
        alignItems: 'flex-end' 
    },
    containerMotelLogo: {
        top: 20,
        left: 20,
        height: 160,
        position: 'absolute',
        width: '30%',
        justifyContent: 'center'
    },
    motelLogo: {
        height: 100,
        width: '100%'
    },
    suite: {
        marginBottom: 20
    }
})
export default styles