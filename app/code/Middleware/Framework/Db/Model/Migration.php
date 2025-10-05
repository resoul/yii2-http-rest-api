<?php
namespace Middleware\Framework\Db\Model;

use yii\db\Migration as BaseMigration;

/**
 * Migration class with extended settings and added standard methods for all application migrations.
 *
 * @author resoul <resoul.ua@icloud.com>
 * @since 0.1
 */
class Migration extends BaseMigration
{
    protected string $table = "";

    protected string $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';

    /**
     * @return void
     */
    public function safeUp(): void
    {
        $this->up();
    }

    /**
     * @return void
     */
    public function safeDown(): void
    {
        $this->down();
    }

    /**
     * @return void
     */
    public function down(): void
    {
        if (!empty($this->table)) {
            $this->dropTable($this->table);
        }
    }

    /**
     * Get table name with prefix
     *
     * @param string $name
     * @return string
     */
    protected function getTableName(string $name = ''): string
    {
        return $name ?: $this->table;
    }

    /**
     * Create timestamp columns
     *
     * @return array
     */
    protected function timestampColumns(): array
    {
        return [
            'created_at' => $this->integer()->notNull()->comment('Created At'),
            'updated_at' => $this->integer()->notNull()->comment('Updated At'),
        ];
    }

    /**
     * Create soft delete column
     *
     * @return array
     */
    protected function softDeleteColumn(): array
    {
        return [
            'deleted_at' => $this->integer()->null()->comment('Deleted At'),
        ];
    }
}