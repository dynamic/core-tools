<?php

/**
 * Class ContentAuthorPermissionManager
 *
 * Apply to DataObjects that don't have permisisons set for non-admins
 */
class ContentAuthorPermissionManager extends DataExtension
{
    /**
     * @param null $member
     * @return bool
     */
    public function canCreate($member = null)
    {
        return true;
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canView($member = null)
    {
        return true;
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canEdit($member = null)
    {
        return true;
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canDelete($member = null)
    {
        return true;
    }
}