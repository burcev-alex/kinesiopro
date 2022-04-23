<?php

namespace App\Domains\User\Models\Traits\Method;

use Illuminate\Support\Collection;

/**
 * Trait UserMethod.
 */
trait UserMethod
{
    /**
     * Супер-админ
     *
     * @return bool
     */
    public function isMasterAdmin(): bool
    {
        return $this->id === 1;
    }

    /**
     * Админ
     *
     * @return mixed
     */
    public function isAdmin(): bool
    {
        return true;
    }

    /**
     * Покупатель
     *
     * @return mixed
     */
    public function isUser(): bool
    {
        return true;
    }

    /**
     * Проверка на полные права
     *
     * @return mixed
     */
    public function hasAllAccess(): bool
    {
        return $this->isAdmin() && $this->hasRole(config('strizhi.access.role.admin'));
    }

    /**
     * Тип пользователя
     *
     * @param $type
     *
     * @return bool
     */
    public function isType($type): bool
    {
        return $this->type === $type;
    }

    /**
     * Можно изменять емайл?
     *
     * @return mixed
     */
    public function canChangeEmail(): bool
    {
        return config('strizhi.access.user.change_email');
    }

    /**
     * Проверка на активность
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Проверка на верификацию
     *
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->email_verified_at !== null;
    }

    /**
     * Привяка к соц.сетям
     *
     * @return bool
     */
    public function isSocial(): bool
    {
        return $this->provider && $this->provider_id;
    }

    /**
     * Группировка по описанию
     *
     * @return Collection
     */
    public function getPermissionDescriptions(): Collection
    {
        return $this->permissions->pluck('description');
    }

    /**
     * Произвольная аватарка
     *
     * @param  bool  $size
     *
     * @return mixed|string
     * @throws \Creativeorange\Gravatar\Exceptions\InvalidEmailException
     */
    public function getAvatar($size = null)
    {
        $md5 = md5(strtolower(trim($this->email)));
        
        return 'https://gravatar.com/avatar/'.$md5.'?s='.config('strizhi.avatar.size', $size).'&d=mp';
    }
}
