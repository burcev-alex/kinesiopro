<?php

namespace App\Domains\User\Models\Traits\Method;

use Illuminate\Support\Collection;

/**
 * Trait UserMethod.
 */
trait UserMethod
{
    /**
     * @return bool
     */
    public function isMasterAdmin(): bool
    {
        return $this->id === 1;
    }

    /**
     * @return mixed
     */
    public function isAdmin(): bool
    {
        return true;
    }

    /**
     * @return mixed
     */
    public function isUser(): bool
    {
        return true;
    }

    /**
     * @return mixed
     */
    public function hasAllAccess(): bool
    {
        return $this->isAdmin() && $this->hasRole(config('strizhi.access.role.admin'));
    }

    /**
     * @param $type
     *
     * @return bool
     */
    public function isType($type): bool
    {
        return $this->type === $type;
    }

    /**
     * @return mixed
     */
    public function canChangeEmail(): bool
    {
        return config('strizhi.access.user.change_email');
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->email_verified_at !== null;
    }

    /**
     * @return bool
     */
    public function isSocial(): bool
    {
        return $this->provider && $this->provider_id;
    }

    /**
     * @return Collection
     */
    public function getPermissionDescriptions(): Collection
    {
        return $this->permissions->pluck('description');
    }

    /**
     * @param  bool  $size
     *
     * @return mixed|string
     * @throws \Creativeorange\Gravatar\Exceptions\InvalidEmailException
     */
    public function getAvatar($size = null)
    {
        return 'https://gravatar.com/avatar/'.md5(strtolower(trim($this->email))).'?s='.config('strizhi.avatar.size', $size).'&d=mp';
    }
}
