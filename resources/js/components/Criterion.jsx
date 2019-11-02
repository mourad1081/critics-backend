import * as React from "react";
import * as PropTypes from "prop-types";
import {Icon, Slider, Input, Row, Col, Divider, Typography, Switch, Form, Upload, Button} from "antd";
import duix from 'duix';
import '../../sass/criterion.scss';

const {TextArea} = Input;
const { Text } = Typography;
const store = duix;

export default class Criterion extends React.Component{
    constructor(props) {
        super(props);

        this.state = {
            score: 0,
            note: '',
            title: '',
            scoreMax: 10,
            priority: 0,
            enabledCriterion: true
        };

        this.listeners = [];

        this.setScore = this.setScore.bind(this);
        this.setNote = this.setNote.bind(this);
        this.toggleCriterion = this.toggleCriterion.bind(this);
        this.onReviewChange = this.onReviewChange.bind(this);
    }

    componentDidMount() {
        const review = store.get('review');
        const criterion = review.getCriterion(this.props.sectionId, this.props.id);
        if (criterion) {
            this.setState({
                score: criterion.score || 0,
                note: criterion.note || '',
                title: criterion.title,
                score_max: criterion.score_max,
                priority: criterion.priority,
            });
        }

        this.listeners.push(store.subscribe('review', this.onReviewChange));
    }

    onReviewChange(review) {
        const criterion = review.getCriterion(this.props.sectionId, this.props.id);

        this.setState({
            score: criterion.score || 0,
            note: criterion.note || '',
            title: criterion.title,
            score_max: criterion.score_max,
            priority: criterion.priority,
        });
    }

    toggleCriterion(isChecked) {
        this.setState({enabledCriterion: isChecked});
    }

    setScore(value) {
        const review = store.get('review');
        review.setCriterion(this.props.sectionId, this.props.id, {score: value});
    }

    setNote(event) {
        const review = store.get('review');
        review.setCriterion(this.props.sectionId, this.props.id, {note: event.target.value});
    }

    renderForm() {
        let marks = {};

        for (let i = 0; i <= +this.state.score_max; i++) {
            let color = null;
            if(i < this.state.score_max / 2)
                color = 'red';
            else if(i < this.state.score_max / 1.5)
                color = 'orange';
            else if(i < this.state.score_max / 1.25)
                color = 'lightgreen';
            else if(i <= this.state.score_max)
                color = 'green';

            marks[i] = {
                label: i,
                style: {
                    border: 'solid #dadada 1px',
                    textAlign: 'center',
                    borderRadius: 5,
                    height: 24,
                    width: 24,
                    marginTop: 5,
                    backgroundColor: '#eee',
                    color: color
                }
            };

        }

        const formatter = (value) => {
            if(value < this.state.score_max / 2)
                return 'Bad';
            else if(value < this.state.score_max / 1.5)
                return 'Average';
            else if(value < this.state.score_max / 1.25)
                return 'Above average';
            else if(value < this.state.score_max / 1.125)
                return 'Good';
            else if(value <= this.state.score_max)
                return 'Excellent';
        };

        return (
            <div>
                <Row>
                    <Col xs={24} sm={3} className='text-center text-muted'>
                        <strong>Score</strong><br/>
                        {`${this.state.score} / ${this.state.score_max}`}
                        </Col>
                    <Col xs={24} sm={21}>
                        <Slider marks={marks}
                                tipFormatter={formatter}
                                max={+this.state.score_max}
                                step={0.5}
                                onChange={this.setScore}
                                value={this.state.score}
                                style={{ marginTop: 5 }} />
                    </Col>
                </Row>

                <Divider className='mt-4' orientation="left">
                    <small className='text-muted'><Icon type="form" className='mr-2'/> Notes</small>
                </Divider>

                <TextArea rows={4}
                          onChange={this.setNote}
                          value={this.state.note}
                          placeholder={'Write here your comment regarding this criterion'}/>
                <Form.Item>
                    <Upload name="logo" action="/upload.do" listType="picture">
                        <Button><Icon type="picture" /> Upload pictures</Button>
                    </Upload>
                </Form.Item>
            </div>
        );
    }

    render() {
        return (
            <div className='criterion'>
                <Text strong className='mb-4'>
                    <Row>
                        <Col xs={24} sm={2} className='text-xs-center text-sm-left mb-xs-2'>
                            <Switch checkedChildren="Applicable"
                                    unCheckedChildren="Not applicable"
                                    className='mr-3'
                                    defaultChecked
                                    onChange={this.toggleCriterion}
                                    style={{width:110}} />
                        </Col>
                        <Col xs={24} sm={22}>
                            <Icon type="line-chart" className='mr-2' />
                            {this.state.title}
                        </Col>
                    </Row>


                </Text>
                <hr/>
                {this.state.enabledCriterion ?
                    this.renderForm()
                    : <Text className='text-muted'>Not applicable criterion</Text>
                }
            </div>
        );
    }
}

Criterion.propTypes = {
    id: PropTypes.number.isRequired,
    sectionId: PropTypes.number.isRequired
};
