import { StyleSheet, Dimensions } from 'react-native'
const { width } = Dimensions.get('window')
const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: '#fff',
    },
    apresentation: { 
        height: 'auto',
        backgroundColor: '#fff',
        padding: 15,
        paddingBottom: 45,
        width: width - 20,
        marginTop: 5,
        marginHorizontal: 10, 
        borderBottomWidth: 1,
        borderBottomColor: '#ddd',
        
    },
    installationsContainer: {  
        marginHorizontal: 20, 
        marginBottom: 10, 
        height: 170, 
        backgroundColor: '#fff',
    },
    installationsRow: { 
        flex: 1, 
        flexDirection: 'row', 
        justifyContent: 'space-between' 
    },
    installationItem: {
        justifyContent: 'center',
        alignItems: 'center',
        width: 65, 
        height: 65, 
        backgroundColor: '#fff'
    }

})
export default styles