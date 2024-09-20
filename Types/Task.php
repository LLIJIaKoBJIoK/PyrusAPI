<?php

/*
 * Сущность "Задача" Pyrus. Хранит все поля задачи и их get/set/add/remove методы
 *
 */

namespace App\Http\Controllers\ITSM\Pyrus\Types;


class Task
{
    //свойства задачи Pyrus
    private int $id;
    private string $text;
    private string $formattedText;
    private string $createDate;
    private string $lastModifiedDate;
    private array $author;
    private array $listIds;
    private array $subscribers;
    private int $formId;
    private array $approvals;
    private int $currentStep;
    private array $attachments;
    private array $fields;
    private array $steps;
    private array $comments;
    private bool $isClosed = false;
    private string $closeDate = '';

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getFormattedText(): string
    {
        return $this->formattedText;
    }

    /**
     * @return string
     */
    public function getCreateDate(): string
    {
        return $this->createDate;
    }

    /**
     * @return string
     */
    public function getLastModifiedDate(): string
    {
        return $this->lastModifiedDate;
    }

    /**
     * @return array
     */
    public function getAuthor(): array
    {
        return $this->author;
    }

    /**
     * @return array
     */
    public function getListIds(): array
    {
        return $this->listIds;
    }

    /**
     * @return array
     */
    public function getSubscribers(): array
    {
        return $this->subscribers;
    }

    /**
     * @return int
     */
    public function getFormId(): int
    {
        return $this->formId;
    }

    public function setFormId(int $formId): static
    {
        $this->formId = $formId;

        return $this;
    }

    /**
     * @return array
     */
    public function getApprovals(): array
    {
        return $this->approvals;
    }

    /**
     * @return int
     */
    public function getCurrentStep(): int
    {
        return $this->currentStep;
    }

    /**
     * @return array
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param $id
     * @return string[]
     */
    public function getField($id): array
    {
        return array_key_exists($id, $this->fields) ? $this->fields[$id] : ['Неверное ID значение поля'];
    }

    /**
     * @param $field
     * @return $this
     */
    public function addField($field): static
    {
        $this->fields[] = $field;

        return $this;
    }

    /**
     * @return array
     */
    public function getSteps(): array
    {
        return $this->steps;
    }

    /**
     * @return array
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @param array $comment
     * @return void
     */
    public function addComment(array $comment): void
    {
        $this->comments['new'] = $comment;
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        return $this->isClosed;
    }

    /**
     * @return string
     */
    public function getCloseDate(): string
    {
        return $this->closeDate;
    }
}
