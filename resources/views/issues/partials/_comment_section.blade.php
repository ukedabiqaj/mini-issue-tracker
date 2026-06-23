<div id="issue-comments"
     data-comments-url="{{ route('issues.comments.index', $issue) }}"
     data-store-url="{{ route('issues.comments.store', $issue) }}">
    <h2 class="mb-4 text-lg font-semibold text-slate-900">Comments</h2>

    <form id="comment-form" class="mb-6 rounded-xl border border-slate-200 bg-slate-50 p-4">
        <div class="mb-3">
            <label for="author_name" class="mb-1 block text-sm font-medium text-slate-700">Your name</label>
            <input type="text" name="author_name" id="author_name" required
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
            <p id="comment-error-author_name" class="mt-1 hidden text-sm text-red-600"></p>
        </div>
        <div class="mb-3">
            <label for="body" class="mb-1 block text-sm font-medium text-slate-700">Comment</label>
            <textarea name="body" id="body" rows="3" required
                      class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"></textarea>
            <p id="comment-error-body" class="mt-1 hidden text-sm text-red-600"></p>
        </div>
        <p id="comment-error-generic" class="mb-3 hidden text-sm text-red-600"></p>
        <button type="submit"
                id="comment-submit-btn"
                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
            Add Comment
        </button>
    </form>

    <div id="comments-list" class="space-y-4"></div>
    <p id="comments-empty" class="hidden text-sm text-slate-500">No comments yet. Be the first to comment.</p>
    <p id="comments-loading" class="text-sm text-slate-500">Loading comments...</p>

    <div id="comments-pagination" class="mt-4 hidden">
        <button type="button" id="load-more-comments"
                class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
            Load more
        </button>
    </div>
</div>
