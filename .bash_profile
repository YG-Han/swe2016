# .bash_profile

# Get the aliases and functions
if [ -f /etc/userbashrc ]; then
        . /etc/userbashrc
fi
# User specific environment and startup programs


LANG=ko_KR.UTF-8
export LANG

JAVA_HOME=/usr/local/jdk
export JAVA_HOME

PATH=/home/bin:/bin:$JAVA_HOME/bin:/usr/local/src/j2sdk1.3.1/bin:/usr/bin:/usr/local/ruby/bin

export PATH
unset USERNAME
