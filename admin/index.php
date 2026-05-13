<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_admin();

$message = '';
$error = '';
$editingProject = null;

try {
    if (isset($_GET['edit'])) {
        $stmt = db()->prepare('SELECT * FROM projects WHERE id = :id');
        $stmt->execute(['id' => (int) $_GET['edit']]);
        $editingProject = $stmt->fetch() ?: null;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        verify_csrf();

        $action = $_POST['action'] ?? '';

        if ($action === 'delete') {
            $stmt = db()->prepare('DELETE FROM projects WHERE id = :id');
            $stmt->execute(['id' => (int) $_POST['id']]);
            $message = 'Project deleted.';
        }

        if ($action === 'save') {
            $id = (int) ($_POST['id'] ?? 0);
            $title = clean_input($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $technologies = clean_input($_POST['technologies'] ?? '');
            $projectUrl = filter_var(trim($_POST['project_url'] ?? ''), FILTER_VALIDATE_URL) ?: null;
            $displayOrder = (int) ($_POST['display_order'] ?? 0);
            $isPublished = isset($_POST['is_published']) ? 1 : 0;

            if ($title === '' || $description === '') {
                $error = 'Title and description are required.';
            } elseif ($id > 0) {
                $stmt = db()->prepare(
                    'UPDATE projects
                     SET title = :title,
                         description = :description,
                         technologies = :technologies,
                         project_url = :project_url,
                         display_order = :display_order,
                         is_published = :is_published
                     WHERE id = :id'
                );
                $stmt->execute([
                    'title' => $title,
                    'description' => $description,
                    'technologies' => $technologies,
                    'project_url' => $projectUrl,
                    'display_order' => $displayOrder,
                    'is_published' => $isPublished,
                    'id' => $id,
                ]);
                $message = 'Project updated.';
                $editingProject = null;
            } else {
                $stmt = db()->prepare(
                    'INSERT INTO projects (title, description, technologies, project_url, display_order, is_published)
                     VALUES (:title, :description, :technologies, :project_url, :display_order, :is_published)'
                );
                $stmt->execute([
                    'title' => $title,
                    'description' => $description,
                    'technologies' => $technologies,
                    'project_url' => $projectUrl,
                    'display_order' => $displayOrder,
                    'is_published' => $isPublished,
                ]);
                $message = 'Project added.';
            }
        }
    }

    $projects = db()->query('SELECT * FROM projects ORDER BY display_order ASC, created_at DESC')->fetchAll();
} catch (Throwable $exception) {
    $projects = [];
    $error = 'Database connection failed. Import database/portfolio.sql first.';
}

$formProject = $editingProject ?: [
    'id' => 0,
    'title' => '',
    'description' => '',
    'technologies' => '',
    'project_url' => '',
    'display_order' => 0,
    'is_published' => 1,
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard | Derya Portfolio</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>
  <main class="admin-page">
    <div class="admin-shell">
      <div class="admin-header">
        <div>
          <p class="small-title">Welcome, <?php echo htmlspecialchars(current_admin_name(), ENT_QUOTES, 'UTF-8'); ?></p>
          <h1>Project Dashboard</h1>
        </div>
        <div class="admin-actions">
          <a class="btn secondary-btn" href="../index.php">View Site</a>
          <a class="btn secondary-btn" href="logout.php">Logout</a>
        </div>
      </div>

      <?php if ($message): ?>
        <p class="message-success"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
      <?php endif; ?>

      <?php if ($error): ?>
        <p class="message-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
      <?php endif; ?>

      <section class="admin-panel">
        <h2><?php echo $formProject['id'] ? 'Edit Project' : 'Add Project'; ?></h2>
        <form class="admin-form" method="POST" action="index.php">
          <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
          <input type="hidden" name="action" value="save" />
          <input type="hidden" name="id" value="<?php echo (int) $formProject['id']; ?>" />

          <label>
            Title
            <input type="text" name="title" value="<?php echo htmlspecialchars($formProject['title'], ENT_QUOTES, 'UTF-8'); ?>" required />
          </label>

          <label>
            Description
            <textarea name="description" required><?php echo htmlspecialchars($formProject['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
          </label>

          <label>
            Technologies
            <input type="text" name="technologies" value="<?php echo htmlspecialchars($formProject['technologies'], ENT_QUOTES, 'UTF-8'); ?>" />
          </label>

          <label>
            Project URL
            <input type="url" name="project_url" value="<?php echo htmlspecialchars((string) $formProject['project_url'], ENT_QUOTES, 'UTF-8'); ?>" />
          </label>

          <label>
            Display Order
            <input type="number" name="display_order" value="<?php echo (int) $formProject['display_order']; ?>" />
          </label>

          <label class="checkbox-label">
            <input type="checkbox" name="is_published" <?php echo (int) $formProject['is_published'] === 1 ? 'checked' : ''; ?> />
            Published
          </label>

          <div class="admin-actions">
            <button class="btn primary-btn" type="submit">Save Project</button>
            <?php if ($formProject['id']): ?>
              <a class="btn secondary-btn" href="index.php">Cancel Edit</a>
            <?php endif; ?>
          </div>
        </form>
      </section>

      <section class="admin-table-wrap">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Title</th>
              <th>Technologies</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($projects as $project): ?>
              <tr>
                <td><?php echo htmlspecialchars($project['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($project['technologies'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo (int) $project['is_published'] === 1 ? 'Published' : 'Hidden'; ?></td>
                <td>
                  <div class="admin-actions">
                    <a class="btn secondary-btn compact-btn" href="index.php?edit=<?php echo (int) $project['id']; ?>">Edit</a>
                    <form method="POST" action="index.php">
                      <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                      <input type="hidden" name="action" value="delete" />
                      <input type="hidden" name="id" value="<?php echo (int) $project['id']; ?>" />
                      <button class="btn secondary-btn compact-btn" type="submit">Delete</button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </section>
    </div>
  </main>
</body>
</html>
