sshd config is altered by this role. To prevent any handlers after sshd failing due to the config change a handler has
not been created for sshd. You need to add the following to the end of the playbooks post_tasks section:

```
- name: restart sshd
  service: name=ssh state=restarted enabled=yes
  when: sshd_status.changed
```
