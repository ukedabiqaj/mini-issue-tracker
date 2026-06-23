import { initComments } from './modules/comments';
import { initIssueSearch } from './modules/issue-search';
import { initTags } from './modules/tags';

document.addEventListener('DOMContentLoaded', () => {
    initComments();
    initTags();
    initIssueSearch();
});
