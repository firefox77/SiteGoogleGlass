import React, { Component } from 'react'
import { Text, View, ScrollView,  Image } from 'react-native'
import FilteredMotels from './components/FilteredMotels'
import { ThemeContext, getTheme, Toolbar, Button, COLOR } from 'react-native-material-ui'
import Container from './components/Container'
import uiTheme from './assets/uiTheme'
import Icon from 'react-native-vector-icons/MaterialCommunityIcons'
import logo from './assets/images/logo.png'
import BottomNavigation, { ShiftingTab } from 'react-native-material-bottom-navigation'
import Motels from './components/Motels'
import MinhaConta from './screens/Profile'
import Timeline from './screens/TimelineScreen'
import Reservations from './components/Reservations'
import Discounts from './components/Discounts'




class Home extends Component {
    tabs = [
        {
            isActive: false,
            key: 'reservas',
            icon: 'calendar-heart',
            label: 'Reservas',
            barColor: COLOR.purple400,
            pressColor: 'rgba(255, 255, 255, 0.16)'
        },
        {
            isActive: false,
            key: 'favoritos',
            icon: 'heart',
            label: 'Favoritos',
            barColor: COLOR.purple500,
            pressColor: 'rgba(255, 255, 255, 0.16)'
        },
        {
            isActive: true,
            key: 'home',
            icon: 'home',
            label: 'Motéis',
            barColor: COLOR.purple400,
            pressColor: 'rgba(255, 255, 255, 0.16)'
          },
        {
            isActive: false,
            key: 'descontos',
            icon: 'tag-multiple',
            label: 'Descontos',
            barColor: COLOR.purple500,
            pressColor: 'rgba(255, 255, 255, 0.16)'
        },
        {
            isActive: false,
            key: 'extratos',
            icon: 'calculator',
            label: 'Extratos',
            barColor: COLOR.purple400,
            pressColor: 'rgba(255, 255, 255, 0.16)'
        }
    ]
    constructor(props) {
        super(props);
        this.state = { 
            search: '',
            showFilteredMotels: false,
            activeTab: 'home',
            motels: [
                {
                  id: '1',
                  title: 'vitara',
                  description: 'teste teste'
                },
                {
                  id: '2',
                  title: 'vitara',
                  description: 'teste teste'
                },
                {
                  id: '3',
                  title: 'vitara',
                  description: 'teste teste'
                },
            ],
            filteredMotels: [
                {
                  id: '1',
                  title: 'vitara',
                  description: 'teste teste'
                },
                {
                  id: '2',
                  title: 'vitara',
                  description: 'teste teste'
                },
                {
                  id: '3',
                  title: 'vitara',
                  description: 'teste teste'
                },
            ]
        };
    }
    renderIcon = iconName => ({ isActive }) => {
        return <Icon size={24} color="white" name={iconName} />
    }

    renderTab = ({ tab, isActive }) => (
        <ShiftingTab
            key={tab.key}
            isActive={tab.isActive}
            label={tab.label}
            renderIcon={this.renderIcon(tab.icon)}
            useLayoutAnimation
        />
    )

    tabPress = tab => {
        this.setState({ activeTab: tab.key })
        this.tabs = this.tabs.map(item => {
            item.isActive = false
            if (item.key == tab.key) {
                item.isActive = true
            }
            return item
        })
    }

    onSubmit = () => {
        let showFilteredMotels = false
        if (this.state.search.length > 0) {
            showFilteredMotels = true
        } 
        this.setState({ showFilteredMotels })
    }
    onChangeText = search => {
        uiTheme.palette.primaryTextColor = COLOR.purple500
        uiTheme.palette.secondaryTextColor = COLOR.black
        this.setState({ search })
    }
    render() {        
        const { showFilteredMotels, filteredMotels, activeTab } = this.state
        const { navigation } = this.props
        return (
            <ThemeContext.Provider value={getTheme(uiTheme)}>
                <Container>
                        <Toolbar
                            leftElement="account-circle"
                            centerElement={ <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center', left: -10 }}><Image style={{ width: 100, height: 50, marginLeft: 10 }} resizeMode="cover" source={logo} /></View> }
                            searchable={{
                                autoFocus: true,
                                placeholder: 'Procurar',
                                onSubmitEditing: this.onSubmit,
                                onChangeText: (search) => { this.onChangeText(search) },
                                onSearchCloseRequested: () => { this.setState({ search: '', showFilteredMotels: false }) },
                            }}
                            onLeftElementPress={ () => {this.tabPress({key:'minha-conta'}) }}                            
                        />
                        <ScrollView style={{ flex: 1 }}>
                            { !showFilteredMotels ?
                                activeTab == 'home' ? 
                                    <Motels motels={ this.state.motels } navigation={ navigation } />
                                : activeTab == 'descontos' ?
                                    <Discounts navigation={ navigation } />
                                : activeTab == 'favoritos' ?
                                    <FilteredMotels filteredMotels={ filteredMotels } navigation={ navigation } />
                                : activeTab == 'reservas' ?
                                    <Reservations navigation={ navigation } />
                                : activeTab == 'notificacoes' ?
                                    <View><Text>notificações aqui</Text></View>
                                : activeTab == 'extratos' ?
                                    <Timeline navigation={ navigation } />
                                : activeTab == 'minha-conta' ?
                                    <MinhaConta navigation={ navigation } />
                                : null   
                            : <FilteredMotels filteredMotels={ filteredMotels } navigation={ navigation } /> }
                        </ScrollView>
                    <BottomNavigation renderTab={this.renderTab} tabs={this.tabs} onTabPress={this.tabPress} />
                </Container>
            </ThemeContext.Provider>
        );
    }
}

export default Home;
