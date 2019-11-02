import React from "react";
import Criterion from "./Criterion";
import * as PropTypes from "prop-types";
import {Divider, Icon} from "antd";
import duix from 'duix';

const store = duix;

export default class Section extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            title: '',
            criteria: [],
        };

        this.listeners = [];
        this.onReviewChange = this.onReviewChange.bind(this);
    }

    componentDidMount() {
        const review = store.get('review');
        if (review) {
            this.setState({
                title: review.getSection(this.props.id).title,
                criteria: review.getCriteria(this.props.id)
            });
        }
        this.listeners.push(store.subscribe('review', this.onReviewChange));
    }

    onReviewChange(review) {
        this.setState({
            title: review.getSection(this.props.id).title,
            criteria: review.getSection(this.props.id).criteria
        });
    }

    render() {
        return (
            <section>
                <Divider orientation="left">
                    <strong>
                        <Icon type='unordered-list' className='mr-2'/> {this.state.title}
                    </strong>
                </Divider>

                {this.state.criteria.map(criterion =>
                    <Criterion key={criterion.criterion_definition_id}
                               sectionId={this.props.id}
                               id={criterion.criterion_definition_id}/>
                )}
            </section>
        );
    }
}

Section.propTypes = {
    id: PropTypes.number.isRequired,
    collapsed: PropTypes.bool
};

Section.defaultProps = {
    collapsed: false
};
