import {Review} from "../Review";
import * as mockReview from "./mocks/mock-new-review";

describe('Behavior of the review class is not buggy.', () => {

    const review = new Review(mockReview);

    it('should has the correct type.', () => {
        expect(review).toBeInstanceOf(Review);
    });

    it('should have at least 1 sections', () => {
        expect(review.getSections()).toBeTruthy();
        expect(review.getSections().length).toBeGreaterThan(0);
    });

    it('should have at least 1 criterion', () => {
        const section = review.getSections()[0];
        expect(review.getCriteria(section.section_definition_id)).toBeTruthy();
        expect(review.getCriteria(section.section_definition_id).length).toBeGreaterThan(0);
    })
});
