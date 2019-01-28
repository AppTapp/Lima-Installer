export THEOS=/toolchain4/theos
export SDKBINPATH=/toolchain4/pre/bin
export SYSROOT=/toolchain4/sys
export TARGET_CXX=clang -ccc-host-triple arm-apple-darwin9

GO_EASY_ON_ME = 1
TOOL_NAME = limabe 
limabe_OBJC_FILES = main.m device.m
#SDKVERSION = 4.0
include /toolchain4/theos/makefiles/common.mk 
include /toolchain4/theos/makefiles/tool.mk 

internal-package::
	$(FAKEROOT) chown -R 0:80 $(FW_PACKAGE_STAGING_DIR)

