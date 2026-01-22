<?php
/**
 * Admin Contacts Management Page
 * View and manage contact form submissions
 */
define('ADMIN_PAGE', true);
require_once 'auth.php';
require_once 'includes/functions.php';

// Require admin authentication
require_admin();

$page_title = 'Contact Messages';

// Get status filter from URL
$status_filter = isset($_GET['status']) ? $_GET['status'] : null;

// Get all contacts
$contacts = get_all_contacts($status_filter);
$contact_stats = get_contact_stats();
?>
<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Contact Messages</h1>
    <p class="text-gray-600">Manage customer inquiries and contact form submissions</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Messages</p>
                <p class="text-2xl font-bold text-gray-900 mt-1"><?php echo $contact_stats['total']; ?></p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Pending</p>
                <p class="text-2xl font-bold text-yellow-600 mt-1"><?php echo $contact_stats['pending']; ?></p>
            </div>
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Resolved</p>
                <p class="text-2xl font-bold text-green-600 mt-1"><?php echo $contact_stats['resolved']; ?></p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px">
            <a href="contacts.php" class="<?php echo !$status_filter ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?> whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                All Messages
            </a>
            <a href="contacts.php?status=pending" class="<?php echo $status_filter === 'pending' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?> whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                Pending
            </a>
            <a href="contacts.php?status=resolved" class="<?php echo $status_filter === 'resolved' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?> whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                Resolved
            </a>
        </nav>
    </div>
</div>

<!-- Contacts Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($contacts)): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <p class="mt-4 text-gray-500">No contact messages found</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($contacts as $contact): ?>
                        <tr class="hover:bg-gray-50" data-contact-id="<?php echo $contact['id']; ?>">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">#<?php echo $contact['id']; ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($contact['name']); ?></div>
                                <?php if (!empty($contact['company'])): ?>
                                    <div class="text-xs text-gray-500"><?php echo htmlspecialchars($contact['company']); ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900"><?php echo htmlspecialchars($contact['email']); ?></div>
                                <?php if (!empty($contact['phone'])): ?>
                                    <div class="text-xs text-gray-500"><?php echo htmlspecialchars($contact['phone']); ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900"><?php echo htmlspecialchars($contact['subject']); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($contact['status'] === 'pending'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Resolved
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo date('M d, Y', strtotime($contact['created_at'])); ?></div>
                                <div class="text-xs text-gray-500"><?php echo date('h:i A', strtotime($contact['created_at'])); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="viewContact(<?php echo $contact['id']; ?>)" class="text-blue-600 hover:text-blue-900 mr-3">
                                    View
                                </button>
                                <?php if ($contact['status'] === 'pending'): ?>
                                    <button onclick="updateStatus(<?php echo $contact['id']; ?>, 'resolved')" class="text-green-600 hover:text-green-900">
                                        Resolve
                                    </button>
                                <?php else: ?>
                                    <button onclick="updateStatus(<?php echo $contact['id']; ?>, 'pending')" class="text-yellow-600 hover:text-yellow-900">
                                        Reopen
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- View Contact Modal -->
<div id="contactModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-lg bg-white">
        <!-- Modal Header -->
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-xl font-bold text-gray-900">Contact Message Details</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Modal Content -->
        <div id="modalContent" class="mt-4">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<script>
function viewContact(id) {
    // Show modal
    document.getElementById('contactModal').classList.remove('hidden');
    
    // Load contact details
    fetch('get_contact_details.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const contact = data.contact;
                const statusClass = contact.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800';
                
                document.getElementById('modalContent').innerHTML = `
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <p class="mt-1 text-sm text-gray-900">${escapeHtml(contact.name)}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-sm text-gray-900">${escapeHtml(contact.email)}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <p class="mt-1 text-sm text-gray-900">${contact.phone ? escapeHtml(contact.phone) : 'N/A'}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Company</label>
                                <p class="mt-1 text-sm text-gray-900">${contact.company ? escapeHtml(contact.company) : 'N/A'}</p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Subject</label>
                            <p class="mt-1 text-sm text-gray-900">${escapeHtml(contact.subject)}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Message</label>
                            <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">${escapeHtml(contact.message)}</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusClass}">
                                    ${contact.status.charAt(0).toUpperCase() + contact.status.slice(1)}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Submitted</label>
                                <p class="mt-1 text-sm text-gray-900">${formatDate(contact.created_at)}</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3 pt-4 border-t">
                            ${contact.status === 'pending' ? 
                                `<button onclick="updateStatus(${contact.id}, 'resolved'); closeModal();" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                    Mark as Resolved
                                </button>` : 
                                `<button onclick="updateStatus(${contact.id}, 'pending'); closeModal();" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                                    Reopen
                                </button>`
                            }
                            <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                                Close
                            </button>
                        </div>
                    </div>
                `;
            } else {
                document.getElementById('modalContent').innerHTML = `
                    <p class="text-red-600">${data.message}</p>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('modalContent').innerHTML = `
                <p class="text-red-600">Failed to load contact details</p>
            `;
        });
}

function closeModal() {
    document.getElementById('contactModal').classList.add('hidden');
}

function updateStatus(id, status) {
    if (!confirm(`Are you sure you want to mark this contact as ${status}?`)) {
        return;
    }
    
    fetch('process_contact_action.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=update_status&id=${id}&status=${status}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update status');
    });
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Close modal when clicking outside
document.getElementById('contactModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>

<?php include 'includes/footer.php'; ?>
