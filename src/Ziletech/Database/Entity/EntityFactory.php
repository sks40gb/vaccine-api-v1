<?php

namespace Ziletech\Database\Entity;

class EntityFactory {

    public static function getUserLogin(): UserLogin {
        return new UserLogin();
    }

    public static function getUser(): User {
        return new User();
    }


    public static function getFile(): File {
        return new File();
    }

    public static function getRole(): Role {
        return new Role();
    }

    public static function getSetting(): Setting {
        return new Setting();
    }

    public static function getGenericCode(): GenericCode {
        return new GenericCode();
    }

    public static function getCodeType(): CodeType {
        return new CodeType();
    }

    public static function getCenter(): Center {
        return new Center();
    }

    public static function getSession(): Session {
        return new Session();
    }

    public static function getSlot(): Slot {
        return new Slot();
    }

    public static function getExecutionTracker(): ExecutionTracker {
        return new ExecutionTracker();
    }

}
