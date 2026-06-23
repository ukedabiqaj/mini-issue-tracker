import { apiFetch, debounce, escapeHtml } from '../api';

export function initIssueSearch() {
    const container = document.getElementById('issue-search');
    if (!container) {
        return;
    }

    const input = document.getElementById('issue-search-input');
    const results = document.getElementById('issue-search-results');
    const empty = document.getElementById('issue-search-empty');
    const searchUrl = container.dataset.searchUrl;
    const issuesUrl = container.dataset.issuesUrl;

    const search = debounce(async () => {
        const query = input.value.trim();

        if (query.length < 2) {
            results.classList.add('hidden');
            results.innerHTML = '';
            empty.classList.add('hidden');

            return;
        }

        try {
            const issues = await apiFetch(`${searchUrl}?q=${encodeURIComponent(query)}`);

            if (!issues.length) {
                results.classList.add('hidden');
                empty.classList.remove('hidden');

                return;
            }

            empty.classList.add('hidden');
            results.classList.remove('hidden');
            results.innerHTML = issues
                .map(
                    (issue) => `
                    <a href="${issuesUrl}/${issue.id}"
                       class="block rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 hover:border-indigo-300 hover:bg-indigo-50">
                        <p class="font-medium text-indigo-700">${escapeHtml(issue.title)}</p>
                        <p class="mt-1 text-xs text-slate-500">${escapeHtml(issue.project?.name || '')}</p>
                    </a>
                `,
                )
                .join('');
        } catch {
            results.classList.add('hidden');
        }
    }, 300);

    input?.addEventListener('input', search);
}
