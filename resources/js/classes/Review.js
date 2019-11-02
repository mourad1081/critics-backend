import duix from 'duix';
const store = duix;

export class Review {
    constructor(review, existsInDatabase = false) {
        this.review = review;
        this.csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        this.existsInDatabase = existsInDatabase;

        this.setTitle = title => {
            this.review.title = title;
            store.set('review', this);
        };

        this.getTitle = () => this.review.title;

        this.setSection = section => {
            const s = this.review.sections.find(s => section.section_definition_id === s.section_definition_id);
            s.criteria.forEach(c => this.setCriterion(s, c));
            s.title = section.title;
            s.priority = section.priority;
            store.set('review', this);
        };

        this.getSections = () => {
            return this.review.sections;
        };

        this.getSection = sectionId => {
            return this.review.sections.find(s => sectionId === s.section_definition_id)
        };

        this.setCriterion = (sectionId, criterionId, data) => {
            const criterion = this.getCriterion(sectionId, criterionId);
            Review.setAttributes(criterion, data);
            store.set('review', this);
        };

        this.getCriteria = sectionId => {
            return this.review.sections.find(s => sectionId === s.section_definition_id).criteria;
        };

        this.getCriterion = (sectionId, criterionId) => {
            return this.review.sections.find(s => sectionId === s.section_definition_id).criteria
                                       .find(c => c.criterion_definition_id === criterionId);
        };

        this.save = () => {
            if (this.existsInDatabase) {
                // update
                console.log('saved, so i update');
            } else {
                // save
                fetch('/api/reviews/1', {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": this.csrfToken
                    },
                    method: "post",
                    credentials: "same-origin",
                    body: JSON.stringify({sections: this.review.sections})
                }).then(response => response.json())
                  .then(successfullySaved => this.existsInDatabase = successfullySaved);
            }
        }
    }

    static setAttributes = (source, attributes) => Object.entries(attributes)
                                                         .forEach(([key, value]) => source[key] = value);
}

