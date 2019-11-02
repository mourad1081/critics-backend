import * as React from "react";
import Section from "./Section";
import {Button, Collapse, Icon, Typography} from "antd";
import duix from 'duix';
const {Panel} = Collapse;

const {Title} = Typography;
const store = duix;

export default class NewReview extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            loading: false,
            title: '',
            sections: []
        };

        this.listeners = [];
        this.onReviewChange = this.onReviewChange.bind(this);
    }

    componentDidMount() {
        const review = store.get('review');
        if (review) {
            this.setState({
                title: review.getTitle(),
                sections: review.getSections()
            });
        }

        this.listeners.push(store.subscribe('review', this.onReviewChange));
    }

    onReviewChange(review) {
        this.setState({
            title: review.getTitle(),
            sections: review.getSections()
        });
    }

    render() {
        const customPanelStyle = {
            background: '#eee',
            borderRadius: 7,
            marginBottom: 24,
            border: 0,
            overflow: 'hidden',
            color: 'white',
            boxShadow: 'grey 0px 7px 10px -7px'
        };

        const collapseProperties = {
            bordered: false,
            defaultActiveKey: this.state.sections.length ? this.state.sections[0].priority : [],
            expandIcon: ({ isActive }) => <Icon type="caret-right" rotate={isActive ? 90 : 0} />
        };

        return (
            <main>
                <Title level={2} style={{color: "rgb(0, 21, 41)"}}>{this.state.title}</Title>
                <hr/>
                <Collapse {...collapseProperties}>
                    {this.state.sections.map(section =>
                        <Panel key={section.section_definition_id}
                               header={<span className='text-muted'>{section.title}</span>}
                               style={customPanelStyle}>
                            <Section id={section.section_definition_id} />
                        </Panel>
                    )}
                </Collapse>

                <Button type="primary"
                        loading={this.state.loading}
                        size={'large'}
                        onClick={() => { store.get('review') ? store.get('review').save() : {} }}>
                    <Icon type="cloud-upload" />
                    Save
                </Button>
            </main>
        );
    }
}
