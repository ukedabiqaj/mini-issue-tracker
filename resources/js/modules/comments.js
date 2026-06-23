import { apiFetch, escapeHtml } from '../api';

function clearCommentErrors() {
    ['author_name', 'body', 'generic'].forEach((field) => {
        const el = document.getElementById(`comment-error-${field}`);
        if (el) {
            el.textContent = '';
            el.classList.add('hidden');
        }
    });
}

function showCommentErrors(errors) {
    Object.entries(errors).forEach(([field, messages]) => {
        const el = document.getElementById(`comment-error-${field}`);
        if (el && messages?.[0]) {
            el.textContent = messages[0];
            el.classList.remove('hidden');
        }
    });
}

function renderComment(comment) {
    const date = new Date(comment.created_at).toLocaleString();

    return `
        <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <header class="mb-2 flex items-center justify-between gap-2">
                <span class="font-medium text-slate-900">${escapeHtml(comment.author_name)}</span>
                <time class="text-xs text-slate-500">${date}</time>
            </header>
            <p class="whitespace-pre-wrap text-sm text-slate-700">${escapeHtml(comment.body)}</p>
        </article>
    `;
}

export function initComments() {
    const container = document.getElementById('issue-comments');
    if (!container) {
        return;
    }

    const list = document.getElementById('comments-list');
    const form = document.getElementById('comment-form');
    const empty = document.getElementById('comments-empty');
    const loading = document.getElementById('comments-loading');
    const pagination = document.getElementById('comments-pagination');
    const loadMoreBtn = document.getElementById('load-more-comments');
    const submitBtn = document.getElementById('comment-submit-btn');
    const indexUrl = container.dataset.commentsUrl;
    const storeUrl = container.dataset.storeUrl;

    let nextPageUrl = indexUrl;

    async function loadComments(append = false) {
        if (!nextPageUrl) {
            return;
        }

        if (!append) {
            loading.classList.remove('hidden');
        }

        try {
            const data = await apiFetch(nextPageUrl);
            loading.classList.add('hidden');

            if (data.data.length === 0 && !append) {
                empty.classList.remove('hidden');
            } else {
                empty.classList.add('hidden');
            }

            const html = data.data.map(renderComment).join('');

            if (append) {
                list.insertAdjacentHTML('beforeend', html);
            } else {
                list.innerHTML = html;
            }

            nextPageUrl = data.next_page_url;

            if (nextPageUrl) {
                pagination.classList.remove('hidden');
            } else {
                pagination.classList.add('hidden');
            }
        } catch {
            loading.textContent = 'Failed to load comments.';
        }
    }

    loadMoreBtn?.addEventListener('click', () => loadComments(true));

    form?.addEventListener('submit', async (event) => {
        event.preventDefault();
        clearCommentErrors();

        const authorName = form.author_name.value.trim();
        const body = form.body.value.trim();

        try {
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Saving...';
            }
            const comment = await apiFetch(storeUrl, {
                method: 'POST',
                body: { author_name: authorName, body },
            });

            list.insertAdjacentHTML('afterbegin', renderComment(comment));
            empty.classList.add('hidden');
            form.reset();
        } catch (error) {
            if (error.status === 422 && error.data?.errors) {
                showCommentErrors(error.data.errors);
            } else {
                const genericError = document.getElementById('comment-error-generic');
                if (genericError) {
                    genericError.textContent = 'Failed to add comment. Please try again.';
                    genericError.classList.remove('hidden');
                }
            }
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Add Comment';
            }
        }
    });

    loadComments();
}
