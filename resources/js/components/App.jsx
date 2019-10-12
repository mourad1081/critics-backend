import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import frFR from 'antd/es/locale/fr_FR';
import {Layout, Menu, Breadcrumb, Icon, ConfigProvider, Avatar} from 'antd';

import 'antd/dist/antd.css';

const { Header, Content, Footer, Sider } = Layout;
const { SubMenu } = Menu;

export default class App extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            collapsed: false,
        };

        this.onCollapse = (collapsed) => {
            this.setState({ collapsed });
        }
    }

    render() {

        const imgStyle = {
            width: '100%'
        };
        const iconStyle = {
            verticalAlign: 'text-bottom'
        };

        return (
            <ConfigProvider locale={frFR}>
                <Layout style={{ minHeight: '100vh' }}>
                    <Sider breakpoint="lg" collapsedWidth="0" collapsible
                           collapsed={this.state.collapsed} onCollapse={this.onCollapse}>
                        <div className="logo" />
                        <Menu theme="dark" defaultSelectedKeys={['1']} mode="inline">


                            <img style={imgStyle} src={'https://www.welovesolo.com/wp-content/uploads/vecteezy/24/e43z5wwiidu.jpg'} alt=""/>

                            <p className="text-center my-3">
                                <Avatar size='large' icon="user" /> <span className={'ml-1'}>Boussa El Ouafi</span>
                            </p>

                            <SubMenu key="sub1"
                                     title={
                                         <span>
                                             <Icon type="unordered-list" style={iconStyle} />
                                             <span>Reviews</span>
                                         </span>
                                     }
                            >
                                <Menu.Item key="3">Restaurant</Menu.Item>
                                <Menu.Item key="4">Hotel</Menu.Item>
                                <Menu.Item key="5">Others</Menu.Item>
                            </SubMenu>
                            <Menu.Item key="2">
                                <Icon type="usergroup-add" style={iconStyle} />
                                <span>Users</span>
                            </Menu.Item>
                            <Menu.Item key="9">
                                <Icon type="setting" style={iconStyle} />
                                <span>Settings</span>
                            </Menu.Item>
                        </Menu>
                    </Sider>
                    <Layout>
                        <Header style={{ background: '#fff', padding: 0 }} />
                        <Content style={{ margin: '0 16px' }}>
                            <Breadcrumb style={{ margin: '16px 0' }}>
                                <Breadcrumb.Item>User</Breadcrumb.Item>
                                <Breadcrumb.Item>Bill</Breadcrumb.Item>
                            </Breadcrumb>
                            <div style={{ padding: 24, background: '#fff', minHeight: 360 }}>Bill is a cat.</div>
                        </Content>
                        <Footer style={{ textAlign: 'center' }}>Ant Design ©2018 Created by Ant UED</Footer>
                    </Layout>
                </Layout>
            </ConfigProvider>
        );
    }
}


ReactDOM.render(<App />, document.getElementById('app'));

