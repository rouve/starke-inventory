export default class Auth {
    constructor(user) {
        this.user = user;
    }

    userID() {
        return parseInt(this.user.user.id, 10);
    }

    logged() {
        return this.user !== undefined && !this.isDisabled();
    }

    roles() {
        return this.logged() ? this.user.roles.map(role => role.name) : [];
    }

    permissions() {
        return this.logged() ? this.user.permissions.map(permission => permission.name) : [];
    }

    can(permissionName) {
        return this.logged() && (this.permissions().includes(permissionName) || this.isAdministrator());
    }

    hasRole(roleName) {
        return this.logged() && this.roles().includes(roleName);
    }

    isAdministrator() {
        return this.hasRole('administrator') || this.isSuperAdmin();
    }

    isSuperAdmin() {
        return this.hasRole('super admin');
    }

    isEnabled() {
        return this.user.user.enabled === 1;
    }

    isDisabled() {
        return this.user.user.enabled === 0;
    }
}
