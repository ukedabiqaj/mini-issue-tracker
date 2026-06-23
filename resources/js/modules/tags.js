import { apiFetch, escapeHtml } from '../api';

function sanitizeColor(color) {
    return typeof color === 'string' && /^#[0-9A-Fa-f]{6}$/.test(color) ? color : '#64748b';
}

function openModal(modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    modal.setAttribute('aria-hidden', 'false');
}

function closeModal(modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    modal.setAttribute('aria-hidden', 'true');
}

function renderTags(tags) {
    const list = document.getElementById('issue-tags-list');
    const empty = document.getElementById('issue-tags-empty');

    if (!list) {
        return;
    }

    if (!tags.length) {
        list.innerHTML = '<p id="issue-tags-empty" class="text-sm text-slate-500">No tags attached yet.</p>';

        return;
    }

    list.innerHTML = tags
        .map(
            (tag) => `
            <span class="issue-tag inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-medium text-white"
                  data-tag-id="${tag.id}"
                  style="background-color: ${sanitizeColor(tag.color)}">
                ${escapeHtml(tag.name)}
            </span>
        `,
        )
        .join('');
}

function renderMembers(users) {
    const list = document.getElementById('issue-members-list');

    if (!list) {
        return;
    }

    if (!users.length) {
        list.innerHTML = '<p id="issue-members-empty" class="text-sm text-slate-500">No members assigned yet.</p>';

        return;
    }

    list.innerHTML = users
        .map(
            (user) => `
            <span class="issue-member inline-flex rounded-full bg-slate-200 px-3 py-1 text-xs font-medium text-slate-800"
                  data-user-id="${user.id}">
                ${escapeHtml(user.name)}
            </span>
        `,
        )
        .join('');
}

function updateToggleButton(button, attached, attachLabel, detachLabel) {
    button.dataset.attached = attached ? '1' : '0';
    button.textContent = attached ? detachLabel : attachLabel;
    button.className = `tag-toggle rounded-md px-2 py-1 text-xs font-medium ${
        attached ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-indigo-100 text-indigo-700 hover:bg-indigo-200'
    }`;
}

function updateMemberToggleButton(button, assigned) {
    button.dataset.assigned = assigned ? '1' : '0';
    button.textContent = assigned ? 'Unassign' : 'Assign';
    button.className = `member-toggle rounded-md px-2 py-1 text-xs font-medium ${
        assigned ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-indigo-100 text-indigo-700 hover:bg-indigo-200'
    }`;
}

function syncTagButtons(tags, modal) {
    const attachedIds = new Set(tags.map((tag) => String(tag.id)));

    modal.querySelectorAll('.tag-toggle').forEach((button) => {
        const isAttached = attachedIds.has(String(button.dataset.tagId));
        updateToggleButton(button, isAttached, 'Attach', 'Detach');
    });
}

function syncMemberButtons(users, modal) {
    const assignedIds = new Set(users.map((user) => String(user.id)));

    modal.querySelectorAll('.member-toggle').forEach((button) => {
        const isAssigned = assignedIds.has(String(button.dataset.userId));
        updateMemberToggleButton(button, isAssigned);
    });
}

export function initTags() {
    const tagSection = document.getElementById('issue-tags');
    const memberSection = document.getElementById('issue-members');
    const tagModal = document.getElementById('tag-modal');
    const membersModal = document.getElementById('members-modal');

    if (!tagSection || !tagModal) {
        return;
    }

    const attachBase = tagSection.dataset.attachUrl;
    const detachBase = tagSection.dataset.detachUrl;

    document.getElementById('open-tag-modal')?.addEventListener('click', () => openModal(tagModal));
    document.getElementById('close-tag-modal')?.addEventListener('click', () => closeModal(tagModal));

    tagModal.addEventListener('click', (event) => {
        if (event.target === tagModal) {
            closeModal(tagModal);
        }
    });

    tagModal.querySelectorAll('.tag-toggle').forEach((button) => {
        button.addEventListener('click', async () => {
            const errorEl = document.getElementById('tag-error-generic');
            if (errorEl) {
                errorEl.classList.add('hidden');
            }
            const tagId = button.dataset.tagId;
            const attached = button.dataset.attached === '1';
            const url = `${attached ? detachBase : attachBase}/${tagId}`;

            try {
                const data = await apiFetch(url, { method: attached ? 'DELETE' : 'POST' });
                renderTags(data.tags);
                syncTagButtons(data.tags, tagModal);
            } catch {
                if (errorEl) {
                    errorEl.textContent = 'Failed to update tag. Please try again.';
                    errorEl.classList.remove('hidden');
                }
            }
        });
    });

    if (!memberSection || !membersModal) {
        return;
    }

    const memberAttachBase = memberSection.dataset.attachUrl;
    const memberDetachBase = memberSection.dataset.detachUrl;

    document.getElementById('open-members-modal')?.addEventListener('click', () => openModal(membersModal));
    document.getElementById('close-members-modal')?.addEventListener('click', () => closeModal(membersModal));

    membersModal.addEventListener('click', (event) => {
        if (event.target === membersModal) {
            closeModal(membersModal);
        }
    });

    membersModal.querySelectorAll('.member-toggle').forEach((button) => {
        button.addEventListener('click', async () => {
            const errorEl = document.getElementById('members-error-generic');
            if (errorEl) {
                errorEl.classList.add('hidden');
            }
            const userId = button.dataset.userId;
            const assigned = button.dataset.assigned === '1';
            const url = `${assigned ? memberDetachBase : memberAttachBase}/${userId}`;

            try {
                const data = await apiFetch(url, { method: assigned ? 'DELETE' : 'POST' });
                renderMembers(data.users);
                syncMemberButtons(data.users, membersModal);
            } catch {
                if (errorEl) {
                    errorEl.textContent = 'Failed to update member. Please try again.';
                    errorEl.classList.remove('hidden');
                }
            }
        });
    });
}
