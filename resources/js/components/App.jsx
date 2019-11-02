import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import {Layout, Menu, Icon, Avatar, Typography, Row, Col} from 'antd';
import '../../sass/app.scss';
import 'antd/dist/antd.css';
import NewReview from "./NewReview";
import duix from 'duix';
import {Review} from "../classes/Review";
const { Header, Content, Footer, Sider } = Layout;
const { SubMenu } = Menu;
const { Title } = Typography;

const store = duix;

export default class App extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            collapsed: false
        };

        this.listeners = [];

        this.fetchReviewContent();
        this.onReviewChange = this.onReviewChange.bind(this);
    }

    componentDidMount() {
        this.listeners.push(store.subscribe('review', this.onReviewChange));
    }

    onReviewChange(review) {
        this.forceUpdate();
    }

    fetchReviewContent() {
        fetch('/api/reviews/1/new')
            .then(result => result.json())
            .then(result => store.set('review', new Review(result.review)));
    }

    renderHeader() {

        let completedCriteria = store.get('review') ? store.get('review').getCriterion(1, 1).score : -1;

        return (
            <Header id={'app-header'}>
                <Row>
                    <Col span={4}>
                        <Avatar size='large' icon="user" className='mr-3' />
                        <span className='d-none d-sm-inline-block'>Boussa El Ouafi</span>
                    </Col>
                    <Col span={20}>
                        score 1 1 : {completedCriteria}
                    </Col>
                </Row>
                <Row>
                    <Col span={24} id={'accomplishment'}>
                        <div id={'accomplishment-value'}/>
                    </Col>
                </Row>
            </Header>
        );
    }

    render() {
        const iconStyle = {
            verticalAlign: 'text-bottom'
        };

        return (
            <Layout style={{ minHeight: '100vh' }}>
                <Sider className='d-none d-sm-block'>
                    <div className="logo" />

                    <Menu theme="dark" defaultSelectedKeys={['1']} mode="inline">

                        <SubMenu key="sub1" title={
                            <span>
                            <Icon type="unordered-list" style={iconStyle} />
                            <span>Reviews</span>
                        </span>
                        }>
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
                    {this.renderHeader()}
                    <Content style={{ margin: '0 16px', marginTop: 100 }}>
                        <div style={{ padding: 24, background: '#fff', minHeight: 360 }}>
                            <NewReview/>
                        </div>
                    </Content>

                    <Footer className='text-muted' style={{ textAlign: 'center' }}>Human Horga ©{new Date().getFullYear()}</Footer>
                </Layout>
            </Layout>
        );
    }
}


ReactDOM.render(<App />, document.getElementById('app'));

